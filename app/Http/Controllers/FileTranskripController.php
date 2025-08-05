<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\MasterBerkas;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use App\Helpers\FileHelper;
use App\Helpers\ActivityLogHelper;
use Auth;
class FileTranskripController extends Controller
{

    public function getTranskrip(Request $request)
    {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }
        $gettranskrip = FileTranskrip::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_transkrip.nama_file_trans_id', '=', 'master_berkas_pegawai.id')
        ->select('file_transkrip.id','file_transkrip.nomor_transkrip','file_transkrip.file','master_berkas_pegawai.nama_berkas',
        'file_transkrip.updated_at')
        ->get();
        return DataTables::of($gettranskrip)
        ->editColumn('updated_at',function($gettranskrip) {
            return $gettranskrip->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);

    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_trans_id' => 'required',
            'nomor_transkrip' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_trans_id.required' => 'Nama File Wajib diisi',
            'nomor_transkrip.required' => 'Nomor Transkrip Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan:pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {
                // Validate file upload using helper
                $fileValidation = FileHelper::validateFileUpload($request->file('file'));
                if (!$fileValidation['valid']) {
                    return response()->json([
                        'status' => 400,
                        'error' => ['file' => [$fileValidation['message']]]
                    ]);
                }

                try {
                    $filenameWithExt = $request->file('file')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $filenameSimpan = FileHelper::generateFilenameWithNIP('TRANSKRIP', $request->nomor_transkrip, $request->id_pegawai, $filenameWithExt, $extension);
                    
                    // Move file to destination
                    $request->file('file')->move(public_path('File/Pegawai/Dokumen/Transkrip'), $filenameSimpan);
                    
                    // Verify file was moved successfully
                    if (!file_exists(public_path('File/Pegawai/Dokumen/Transkrip/' . $filenameSimpan))) {
                        throw new \Exception('File tidak berhasil disimpan ke server');
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 500,
                        'error' => ['file' => ['Gagal memproses file: ' . $e->getMessage()]]
                    ]);
                }
    
                $upload = FileTranskrip::create([
                    'id_pegawai' => $request->id_pegawai,
                    //'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_trans_id' => $request->nama_file_trans_id,
                    'nomor_transkrip' => $request->nomor_transkrip,
                    'file' => $filenameSimpan
                ]);

                // Get file size safely
                $fileSize = 0;
                $fileSizeFormatted = '0 bytes';
                try {
                    if ($request->file('file')->isValid()) {
                        $fileSize = $request->file('file')->getSize();
                        $fileSizeFormatted = FileHelper::formatFileSize($fileSize);
                    }
                } catch (\Exception $e) {
                    // Log error but continue with upload
                    \Log::warning('Failed to get file size: ' . $e->getMessage());
                }

                // Log berhasil upload berkas transkrip
                ActivityLogHelper::log(
                    'Berhasil menambahkan berkas transkrip baru',
                    [
                        'pegawai_id' => $request->id_pegawai,
                        'nama_file_trans_id' => $request->nama_file_trans_id,
                        'nomor_transkrip' => $request->nomor_transkrip,
                        'file_name' => $filenameSimpan,
                        'file_size' => $fileSize,
                        'file_size_formatted' => $fileSizeFormatted,
                        'action' => 'create_transkrip'
                    ],
                    'file_transkrip'
                );

                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Transkrip Berhasil Disimpan',
                    'data' => $upload
                ]);
            }
           
        }else {
            // Log validasi gagal
            ActivityLogHelper::log(
                'Validasi gagal saat menambahkan berkas transkrip',
                [
                    'pegawai_id' => $request->id_pegawai ?? 'unknown',
                    'errors' => $validated->messages(),
                    'action' => 'validation_failed'
                ],
                'file_transkrip'
            );

            return response()->json([
                'status' => 400,
                'error' => $validated->errors()
            ]);
        }
    }

    public function edit(Request $request)
    {
        $trans_edit = FileTranskrip::where('id', $request->id)->first();
        if ($trans_edit) {
            return response()->json([
                'message' => 'Data Transkrip Ditemukan',
                'code' => 200,
                'data' => $trans_edit
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }
    }

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_trans_id' => 'required',
            'nomor_transkrip' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_trans_id.required' => 'Nama File Wajib diisi',
            'nomor_transkrip.required' => 'Nomor Transkrip Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan:pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            // Ambil data lama untuk logging
            $oldData = FileTranskrip::where('id', $request->id)->first();
            
            if ($request->hasFile('file')) {
                // Validate file upload
                if (!$request->file('file')->isValid()) {
                    return response()->json([
                        'status' => 400,
                        'error' => ['file' => ['File upload gagal atau file tidak valid']]
                    ]);
                }

                try {
                    $delete_file = FileTranskrip::where('id', $request->id)->first();
                    if ($delete_file && $delete_file->file) {
                        File::delete('File/Pegawai/Dokumen/Transkrip/'.$delete_file->file);
                    }

                    $filenameWithExt = $request->file('file')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $filenameSimpan = FileHelper::generateFilenameWithNIP('TRANSKRIP', $request->nomor_transkrip, $request->id_pegawai, $filenameWithExt, $extension);
                    
                    // Move file to destination
                    $request->file('file')->move(public_path('File/Pegawai/Dokumen/Transkrip'), $filenameSimpan);
                    
                    // Verify file was moved successfully
                    if (!file_exists(public_path('File/Pegawai/Dokumen/Transkrip/' . $filenameSimpan))) {
                        throw new \Exception('File tidak berhasil disimpan ke server');
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 500,
                        'error' => ['file' => ['Gagal memproses file: ' . $e->getMessage()]]
                    ]);
                }
    
                $upload = FileTranskrip::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_trans_id' => $request->nama_file_trans_id,
                    'nomor_transkrip' => $request->nomor_transkrip,
                    'file' => $filenameSimpan
                ]);

                // Get file size safely
                $fileSize = 0;
                $fileSizeFormatted = '0 bytes';
                try {
                    if ($request->file('file')->isValid()) {
                        $fileSize = $request->file('file')->getSize();
                        $fileSizeFormatted = FileHelper::formatFileSize($fileSize);
                    }
                } catch (\Exception $e) {
                    // Log error but continue with upload
                    \Log::warning('Failed to get file size: ' . $e->getMessage());
                }

                // Log update berkas transkrip dengan file baru
                ActivityLogHelper::log(
                    'Berhasil mengubah berkas transkrip dengan file baru',
                    [
                        'transkrip_id' => $request->id,
                        'pegawai_id' => $request->id_pegawai,
                        'old_file' => $oldData->file ?? 'unknown',
                        'new_file' => $filenameSimpan,
                        'old_nomor_transkrip' => $oldData->nomor_transkrip ?? 'unknown',
                        'new_nomor_transkrip' => $request->nomor_transkrip,
                        'file_size' => $fileSize,
                        'file_size_formatted' => $fileSizeFormatted,
                        'action' => 'update_transkrip_with_file'
                    ],
                    'file_transkrip'
                );

                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Transkrip Berhasil Disimpan',
                    'data' => $upload
                ]);
            }else {
                // Rename file lama di storage dan update nama file di database
                $oldFile = $oldData->file;
                $oldPath = public_path('File/Pegawai/Dokumen/Transkrip/' . $oldFile);
                $extension = pathinfo($oldFile, PATHINFO_EXTENSION);
                $filenameWithExt = $oldFile; // gunakan nama lama sebagai original name hash
                $newFileName = FileHelper::generateFilenameWithNIP('TRANSKRIP', $request->nomor_transkrip, $request->id_pegawai, $filenameWithExt, $extension);
                $newPath = public_path('File/Pegawai/Dokumen/Transkrip/' . $newFileName);

                // Rename file di storage jika file lama ada
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                }

                $upload = FileTranskrip::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_trans_id' => $request->nama_file_trans_id,
                    'nomor_transkrip' => $request->nomor_transkrip,
                    'file' => $newFileName
                ]);

                // Log update berkas transkrip tanpa file
                ActivityLogHelper::log(
                    'Berhasil mengubah data berkas transkrip tanpa file',
                    [
                        'transkrip_id' => $request->id,
                        'pegawai_id' => $request->id_pegawai,
                        'old_nomor_transkrip' => $oldData->nomor_transkrip ?? 'unknown',
                        'new_nomor_transkrip' => $request->nomor_transkrip,
                        'old_file' => $oldFile,
                        'new_file' => $newFileName,
                        'action' => 'update_transkrip_data_only'
                    ],
                    'file_transkrip'
                );

                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Transkrip Berhasil Diubah',
                    'data' => $upload
                ]);
            }
           
        }else {
            // Log validasi gagal saat update
            ActivityLogHelper::log(
                'Validasi gagal saat mengubah berkas transkrip',
                [
                    'transkrip_id' => $request->id ?? 'unknown',
                    'pegawai_id' => $request->id_pegawai ?? 'unknown',
                    'errors' => $validated->errors(),
                    'action' => 'update_validation_failed'
                ],
                'file_transkrip'
            );

            return response()->json([
                'status' => 400,
                'error' => $validated->errors()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $transkrip = FileTranskrip::where('id', $request->id)->first();
        $delete = FileTranskrip::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Transkrip/'.$transkrip->file);
            
            // Log hapus berkas transkrip
            ActivityLogHelper::log(
                'Berhasil menghapus berkas transkrip',
                [
                    'transkrip_id' => $request->id,
                    'pegawai_id' => $transkrip->id_pegawai ?? 'unknown',
                    'nomor_transkrip' => $transkrip->nomor_transkrip ?? 'unknown',
                    'file_deleted' => $transkrip->file ?? 'unknown',
                    'action' => 'delete_transkrip'
                ],
                'file_transkrip'
            );

            return response()->json([
                'message' => 'Data Transkrip Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            // Log gagal hapus berkas transkrip
            ActivityLogHelper::log(
                'Gagal menghapus berkas transkrip',
                [
                    'transkrip_id' => $request->id,
                    'pegawai_id' => $transkrip->id_pegawai ?? 'unknown',
                    'nomor_transkrip' => $transkrip->nomor_transkrip ?? 'unknown',
                    'reason' => 'Data masih digunakan',
                    'action' => 'delete_transkrip_failed'
                ],
                'file_transkrip'
            );

            return response()->json([
                'message' => 'Gagal Hapus data, data Masih digunakan',
                'code' => 500,
            ]);
        }
    }

    public function viewPdf($filename)
    {
        // Validasi nama file hanya karakter yang diizinkan (alphanumeric, dash, underscore, dot)
        if (!preg_match('/^[A-Za-z0-9._-]+\.pdf$/', $filename)) {
            abort(404, 'File tidak valid');
        }
        $path = public_path('File/Pegawai/Dokumen/Transkrip/' . $filename);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        // Opsi: tambahkan validasi hak akses user di sini
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
