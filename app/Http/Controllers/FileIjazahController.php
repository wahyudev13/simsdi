<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use App\Models\VerifIjazah;
use App\Models\Departemen;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Helpers\ActivityLogHelper;
use App\Helpers\FileHelper;

class FileIjazahController extends Controller
{
    //Halaman Berkas Ijazah
    public function index($id)
    {
        $pegawai = Pegawai::where('id', $id)->join('departemen','pegawai.departemen','=','departemen.dep_id')
        ->select('pegawai.id','pegawai.nama','pegawai.jbtn','pegawai.nik','departemen.nama AS nama_dep')
        ->first();
        $master_berkas_pendidikan = MasterBerkas::where('kategori','pendidikan')->get();
        $master_berkas_izin = MasterBerkas::where('kategori','ijin')->get();
        $master_berkas_lain = MasterBerkas::where('kategori','lain')->get();
        $master_berkas_identitas = MasterBerkas::where('kategori','identitas')->get();
        $master_berkas_perjanjian = MasterBerkas::where('kategori','perjanjian')->get();
        $master_berkas_orientasi = MasterBerkas::where('kategori','orientasi')->get();
        $deparetemen = Departemen::get();
        $str = FileSTR::where('id_pegawai', $id)->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'proses');
        })->get();
        //$str = FileSTR::where('id_pegawai', $id)->where('status','active')->orwhere('status','proses')->get();
        $data=[
            'pegawai' => $pegawai,
            'master_berkas_pendidikan' => $master_berkas_pendidikan,
            'master_berkas_izin' => $master_berkas_izin,
            'master_berkas_lain' => $master_berkas_lain,
            'master_berkas_identitas' => $master_berkas_identitas,
            'master_berkas_perjanjian' => $master_berkas_perjanjian,
            'master_berkas_orientasi' => $master_berkas_orientasi,
            'file_str' => $str,
            'deparetemen' => $deparetemen,
        ];

        return view('pages.Karyawan.berkas-kepegawaian',$data);
    }

    //Get Brekas Ijazah
    public function getIjazah(Request $request)
    {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }
        $berkas = FileIjazah::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_ijazah.nama_file_id', '=', 'master_berkas_pegawai.id')
        ->leftjoin('verif_ijazah','file_ijazah.id','=','verif_ijazah.ijazah_id')
        ->select('file_ijazah.id AS id_ijazah','master_berkas_pegawai.nama_berkas','file_ijazah.nomor','file_ijazah.asal',
        'file_ijazah.thn_lulus','file_ijazah.file','file_ijazah.updated_at','verif_ijazah.id AS id_verif','verif_ijazah.file AS file_verif',
        'verif_ijazah.keterangan')
        ->get();

        return DataTables::of($berkas)
        ->editColumn('updated_at',function($berkas) {
            return $berkas->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);

    }

    //Store Berkas Ijazah
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_id' => 'required',
            'nomor' => 'required',
            'asal' => 'required',
            'thn_lulus' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_id.required' => 'Nama File Wajib diisi',
            'nomor.required' => 'Nomor Ijazah Wajib diisi',
            'asal.required' => 'Asal Sekolah / Universitas Wajib diisi',
            'thn_lulus.required' => 'Tahun Lulus Wajib diisi',
            'file.required' => 'File Wajib diisi',
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
                    $filenameWithExt = $request->file('file')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $filenameSimpan = FileHelper::generateFilenameWithNIP('IJAZAH', $request->nomor, $request->id_pegawai, $filenameWithExt, $extension);
                    
                    // Move file to destination
                    $request->file('file')->move(public_path('File/Pegawai/Dokumen/Ijazah'), $filenameSimpan);
                    
                    // Verify file was moved successfully
                    if (!file_exists(public_path('File/Pegawai/Dokumen/Ijazah/' . $filenameSimpan))) {
                        throw new \Exception('File tidak berhasil disimpan ke server');
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 500,
                        'error' => ['file' => ['Gagal memproses file: ' . $e->getMessage()]]
                    ]);
                }
    
                $upload = FileIjazah::create([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_id' => $request->nama_file_id,
                    'nomor' => $request->nomor,
                    'asal' => $request->asal,
                    'thn_lulus' => $request->thn_lulus,
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

                // Log berhasil upload berkas ijazah
                ActivityLogHelper::log(
                    'Berhasil menambahkan berkas ijazah baru',
                    [
                        'pegawai_id' => $request->id_pegawai,
                        'nama_file_id' => $request->nama_file_id,
                        'nomor_ijazah' => $request->nomor,
                        'asal' => $request->asal,
                        'tahun_lulus' => $request->thn_lulus,
                        'file_name' => $filenameSimpan,
                        'file_size' => $fileSize,
                        'file_size_formatted' => $fileSizeFormatted,
                        'action' => 'create_ijazah'
                    ],
                    'file_ijazah'
                );

                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Ijazah Berhasil Disimpan',
                    'data' => $upload
                ]);
            }
           
        }else {
            // Log validasi gagal
            ActivityLogHelper::log(
                'Validasi gagal saat menambahkan berkas ijazah',
                [
                    'pegawai_id' => $request->id_pegawai ?? 'unknown',
                    'errors' => $validated->messages(),
                    'action' => 'validation_failed'
                ],
                'file_ijazah'
            );

            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
        
    }

    //Edit Berkas Ijazah
    public function edit(Request $request)
    {
        // /$pegawai = Pegawai::where('id', $id)->first();
        $dokumen = FileIjazah::where('id', $request->id)->first();
        if ($dokumen) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => $dokumen
            ]);
        }else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
            ]);
        }

    }

    //Update Berkas Ijazah
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_ijazah_edit' => 'required',
            'nomor_ijazah_edit' => 'required',
            'asal_ijazah_edit' => 'required',
            'thn_lulus_ijazah_edit' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_ijazah_edit.required' => 'Nama File Wajib diisi',
            'nomor_ijazah_edit.required' => 'Nomor Ijazah Wajib diisi',
            'asal_ijazah_edit.required' => 'Asal Sekolah / Universitas Wajib diisi',
            'thn_lulus_ijazah_edit.required' => 'Tahun Lulus Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            // Ambil data lama untuk logging
            $oldData = FileIjazah::where('id', $request->id_ijazah)->first();
            
            if ($request->hasFile('file')) {
                // Validate file upload
                if (!$request->file('file')->isValid()) {
                    return response()->json([
                        'status' => 400,
                        'error' => ['file' => ['File upload gagal atau file tidak valid']]
                    ]);
                }

                try {
                    $delete_file = FileIjazah::where('id', $request->id_ijazah)->first();
                    if ($delete_file && $delete_file->file) {
                        File::delete('File/Pegawai/Dokumen/Ijazah/'.$delete_file->file);
                    }

                    $filenameWithExt = $request->file('file')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $filenameSimpan = FileHelper::generateFilenameWithNIP('IJAZAH', $request->nomor_ijazah_edit, $request->id_pegawai, $filenameWithExt, $extension);
                    
                    // Move file to destination
                    $request->file('file')->move(public_path('File/Pegawai/Dokumen/Ijazah'), $filenameSimpan);
                    
                    // Verify file was moved successfully
                    if (!file_exists(public_path('File/Pegawai/Dokumen/Ijazah/' . $filenameSimpan))) {
                        throw new \Exception('File tidak berhasil disimpan ke server');
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 500,
                        'error' => ['file' => ['Gagal memproses file: ' . $e->getMessage()]]
                    ]);
                }
    
                $upload = FileIjazah::where('id',$request->id_ijazah)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_id' => $request->nama_file_ijazah_edit,
                    'nomor' => $request->nomor_ijazah_edit,
                    'asal' => $request->asal_ijazah_edit,
                    'thn_lulus' => $request->thn_lulus_ijazah_edit,
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

                // Log update berkas ijazah dengan file baru
                ActivityLogHelper::log(
                    'Berhasil mengubah berkas ijazah dengan file baru',
                    [
                        'ijazah_id' => $request->id_ijazah,
                        'pegawai_id' => $request->id_pegawai,
                        'old_file' => $oldData->file ?? 'unknown',
                        'new_file' => $filenameSimpan,
                        'old_nomor' => $oldData->nomor ?? 'unknown',
                        'new_nomor' => $request->nomor_ijazah_edit,
                        'old_asal' => $oldData->asal ?? 'unknown',
                        'new_asal' => $request->asal_ijazah_edit,
                        'old_thn_lulus' => $oldData->thn_lulus ?? 'unknown',
                        'new_thn_lulus' => $request->thn_lulus_ijazah_edit,
                        'file_size' => $fileSize,
                        'file_size_formatted' => $fileSizeFormatted,
                        'action' => 'update_ijazah_with_file'
                    ],
                    'file_ijazah'
                );

                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Ijazah Berhasil Diubah',
                    'data' => $upload
                ]);
            }else {
                // Rename file lama di storage dan update nama file di database
                $oldFile = $oldData->file;
                $oldPath = public_path('File/Pegawai/Dokumen/Ijazah/' . $oldFile);
                $extension = pathinfo($oldFile, PATHINFO_EXTENSION);
                $filenameWithExt = $oldFile; // gunakan nama lama sebagai original name hash
                $newFileName = FileHelper::generateFilenameWithNIP('IJAZAH', $request->nomor_ijazah_edit, $request->id_pegawai, $filenameWithExt, $extension);
                $newPath = public_path('File/Pegawai/Dokumen/Ijazah/' . $newFileName);

                // Rename file di storage jika file lama ada
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                }

                $upload = FileIjazah::where('id',$request->id_ijazah)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_id' => $request->nama_file_ijazah_edit,
                    'nomor' => $request->nomor_ijazah_edit,
                    'asal' => $request->asal_ijazah_edit,
                    'thn_lulus' => $request->thn_lulus_ijazah_edit,
                    'file' => $newFileName
                ]);

                // Log update berkas ijazah tanpa file
                ActivityLogHelper::log(
                    'Berhasil mengubah data berkas ijazah tanpa file',
                    [
                        'ijazah_id' => $request->id_ijazah,
                        'pegawai_id' => $request->id_pegawai,
                        'old_nomor' => $oldData->nomor ?? 'unknown',
                        'new_nomor' => $request->nomor_ijazah_edit,
                        'old_asal' => $oldData->asal ?? 'unknown',
                        'new_asal' => $request->asal_ijazah_edit,
                        'old_thn_lulus' => $oldData->thn_lulus ?? 'unknown',
                        'new_thn_lulus' => $request->thn_lulus_ijazah_edit,
                        'old_file' => $oldFile,
                        'new_file' => $newFileName,
                        'action' => 'update_ijazah_data_only'
                    ],
                    'file_ijazah'
                );

                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Ijazah Berhasil Diubah',
                    'data' => $upload
                ]);
            }
           
        }else {
            // Log validasi gagal saat update
            ActivityLogHelper::log(
                'Validasi gagal saat mengubah berkas ijazah',
                [
                    'ijazah_id' => $request->id_ijazah ?? 'unknown',
                    'pegawai_id' => $request->id_pegawai ?? 'unknown',
                    'errors' => $validated->messages(),
                    'action' => 'update_validation_failed'
                ],
                'file_ijazah'
            );

            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }

    //Hapus Berkas Ijazah
    public function destroy(Request $request)
    {
        $dokumen = FileIjazah::where('id', $request->id)->first();
        $dokumenbukti = VerifIjazah::where('ijazah_id', $request->id)->first();
    
        $delete = FileIjazah::where('id', $request->id)->delete();
        if ($delete) {
            if ($dokumenbukti == null) {
                File::delete('File/Pegawai/Dokumen/Ijazah/'.$dokumen->file);
                
                // Log hapus berkas ijazah tanpa bukti verifikasi
                ActivityLogHelper::log(
                    'Berhasil menghapus berkas ijazah',
                    [
                        'ijazah_id' => $request->id,
                        'pegawai_id' => $dokumen->id_pegawai ?? 'unknown',
                        'nomor_ijazah' => $dokumen->nomor ?? 'unknown',
                        'asal' => $dokumen->asal ?? 'unknown',
                        'file_deleted' => $dokumen->file ?? 'unknown',
                        'verifikasi_exists' => false,
                        'action' => 'delete_ijazah_only'
                    ],
                    'file_ijazah'
                );

                return response()->json([
                    'message' => 'Data Ijazah Berhasil Dihapus',
                    'code' => 200,
                ]);
            }else {
                File::delete('File/Pegawai/Dokumen/Ijazah/'.$dokumen->file);
                File::delete('File/Pegawai/Dokumen/Ijazah/Verifikasi/'.$dokumenbukti->file);
                
                // Log hapus berkas ijazah dengan bukti verifikasi
                ActivityLogHelper::log(
                    'Berhasil menghapus berkas ijazah dan bukti verifikasi',
                    [
                        'ijazah_id' => $request->id,
                        'pegawai_id' => $dokumen->id_pegawai ?? 'unknown',
                        'nomor_ijazah' => $dokumen->nomor ?? 'unknown',
                        'asal' => $dokumen->asal ?? 'unknown',
                        'file_deleted' => $dokumen->file ?? 'unknown',
                        'verifikasi_id' => $dokumenbukti->id ?? 'unknown',
                        'verifikasi_file_deleted' => $dokumenbukti->file ?? 'unknown',
                        'verifikasi_exists' => true,
                        'action' => 'delete_ijazah_with_verifikasi'
                    ],
                    'file_ijazah'
                );

                return response()->json([
                    'message' => 'Data Ijazah & Bukti Verifikasi Berhasil Dihapus',
                    'code' => 200,
                ]);
            }
        }else {
            // Log error saat hapus berkas ijazah
            ActivityLogHelper::log(
                'Gagal menghapus berkas ijazah',
                [
                    'ijazah_id' => $request->id,
                    'error' => 'Database delete failed',
                    'action' => 'delete_ijazah_failed'
                ],
                'file_ijazah'
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
        $path = public_path('File/Pegawai/Dokumen/Ijazah/' . $filename);
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
