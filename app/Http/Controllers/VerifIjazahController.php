<?php

namespace App\Http\Controllers;

use App\Models\VerifIjazah;
use App\Models\FileIjazah;
use App\Models\Pegawai;
use App\Helpers\ActivityLogHelper;
use App\Helpers\FileHelper;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;

use Illuminate\Http\Request;

class VerifIjazahController extends Controller
{
    public function index()
    {
        
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'file.required' => 'File Bukti Verifikasi Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
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
                    // Get ijazah data to get pegawai_id
                    $ijazah = FileIjazah::find($request->ijazah_id);
                    if (!$ijazah) {
                        return response()->json([
                            'status' => 400,
                            'error' => ['ijazah_id' => ['Data ijazah tidak ditemukan']]
                        ]);
                    }

                    $filenameWithExt = $request->file('file')->getClientOriginalName();
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $filenameSimpan = FileHelper::generateVerifIjazahFilename($request->ijazah_id, $extension, $ijazah->id_pegawai);
                    
                    // Move file to destination
                    $request->file('file')->move(public_path('File/Pegawai/Dokumen/Ijazah/Verifikasi'), $filenameSimpan);
                    
                    // Verify file was moved successfully
                    if (!file_exists(public_path('File/Pegawai/Dokumen/Ijazah/Verifikasi/' . $filenameSimpan))) {
                        throw new \Exception('File tidak berhasil disimpan ke server');
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 500,
                        'error' => ['file' => ['Gagal memproses file: ' . $e->getMessage()]]
                    ]);
                }
    
                $upload = VerifIjazah::create([
                    'ijazah_id' => $request->ijazah_id,
                    'file' => $filenameSimpan,
                    'keterangan' => $request->ket_bukti
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

                // Log aktivitas berhasil upload bukti verifikasi
                ActivityLogHelper::log(
                    'Berhasil menambahkan bukti verifikasi ijazah',
                    [
                        'ijazah_id' => $request->ijazah_id,
                        'pegawai_id' => $ijazah->id_pegawai,
                        'file_name' => $filenameSimpan,
                        'original_filename' => $filenameWithExt,
                        'file_size' => $fileSize,
                        'file_size_formatted' => $fileSizeFormatted,
                        'keterangan' => $request->ket_bukti,
                        'action' => 'create_verifikasi_ijazah'
                    ],
                    'verifikasi_ijazah'
                );

                return response()->json([
                    'status' => 200,
                    'message' => 'Bukti Verifikasi Berhasil Disimpan',
                    'data' => $upload
                ]);
            }
           
        }else {
            // Log aktivitas validasi gagal
            ActivityLogHelper::log(
                'Validasi gagal saat menambahkan bukti verifikasi ijazah',
                [
                    'ijazah_id' => $request->ijazah_id ?? 'unknown',
                    'errors' => $validated->errors(),
                    'action' => 'validation_failed_verifikasi_ijazah'
                ],
                'verifikasi_ijazah'
            );

            return response()->json([
                'status' => 400,
                'error' => $validated->errors()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $dokumen = VerifIjazah::where('id', $request->id)->first();
    
        $delete = VerifIjazah::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Ijazah/Verifikasi/'.$dokumen->file);
            
            // Log aktivitas berhasil hapus bukti verifikasi
            ActivityLogHelper::log(
                'Berhasil menghapus bukti verifikasi ijazah',
                [
                    'verifikasi_id' => $request->id,
                    'ijazah_id' => $dokumen->ijazah_id ?? 'unknown',
                    'file_deleted' => $dokumen->file ?? 'unknown',
                    'keterangan' => $dokumen->keterangan ?? 'unknown',
                    'action' => 'delete_verifikasi_ijazah'
                ],
                'verifikasi_ijazah'
            );

            return response()->json([
                'message' => 'Data Bukti Verifikasi Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            // Log aktivitas error saat hapus
            ActivityLogHelper::log(
                'Error saat menghapus bukti verifikasi ijazah',
                [
                    'verifikasi_id' => $request->id,
                    'error' => 'Database delete operation failed',
                    'action' => 'delete_error_verifikasi_ijazah'
                ],
                'verifikasi_ijazah'
            );

            return response()->json([
                'message' => 'Internal Server Error',
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
        $path = public_path('File/Pegawai/Dokumen/Ijazah/Verifikasi/' . $filename);
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
