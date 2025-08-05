<?php

namespace App\Http\Controllers;

use App\Models\VerifStr;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogHelper;

class VerifStrController extends Controller
{
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

                $file = $request->file('file');
                $originalName = $file->getClientOriginalName(); // Nama file asli
                $extension = $file->getClientOriginalExtension();
                $fileSize = $file->getSize(); // Get file size before moving
                
                // Ambil data STR untuk mendapatkan nomor STR dan NIP pegawai
                $str = \App\Models\FileSTR::find($request->str_id);
                if ($str) {
                    $pegawai = \App\Models\Pegawai::find($str->id_pegawai);
                    $nip = $pegawai ? $pegawai->nik : $str->id_pegawai;
                    
                    // Bersihkan nomor STR dari karakter khusus
                    $noRegStr = preg_replace('/[^A-Za-z0-9]/', '', $str->no_reg_str);
                    
                    // Format nama file baru: STR_VERIF_nomorSTR_nip_tanggal_hash
                    $currentDate = date('Ymd');
                    $hash = substr(md5($originalName . time()), 0, 6);
                    $filenameSimpan = 'STR_VERIF_' . $noRegStr . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                } else {
                    // Fallback jika STR tidak ditemukan
                    $currentDate = date('Ymd');
                    $hash = substr(md5($originalName . time()), 0, 6);
                    $filenameSimpan = 'STR_VERIF_' . $currentDate . '_' . $hash . '.' . $extension;
                }
                
                $file->move(public_path('File/Pegawai/Dokumen/STR/Verifikasi'), $filenameSimpan);
    
                $upload = VerifStr::create([
                    'str_id' => $request->str_id,
                    'file_verif' => $filenameSimpan,
                    'keterangan' => $request->ket_bukti
                ]);

                // Log activity for successful file upload
                ActivityLogHelper::log('Uploaded STR verification file', [
                    'str_id' => $request->str_id,
                    'file_name' => $filenameSimpan,
                    'original_file_name' => $originalName,
                    'file_size' => $fileSize,
                    'file_extension' => $extension,
                    'keterangan' => $request->ket_bukti,
                    'pegawai_nip' => $nip ?? null,
                    'no_reg_str' => $noRegStr ?? null
                ], 'verif_str');

                return response()->json([
                    'status' => 200,
                    'message' => 'Bukti Verifikasi STR Berhasil Disimpan',
                    'data' => $upload
                ]);
            }
           
        }else {
            return response()->json([
                'status' => 400,
                'error' => $validated->messages()
            ]);
        }
    }
   
    public function destroy(Request $request)
    {
        $dokumen = VerifStr::where('id', $request->id)->first();
    
        if ($dokumen) {
            // Log activity before deletion
            ActivityLogHelper::log('Deleted STR verification file', [
                'verif_str_id' => $request->id,
                'str_id' => $dokumen->str_id,
                'file_name' => $dokumen->file_verif,
                'keterangan' => $dokumen->keterangan,
                'deleted_at' => now()->toISOString()
            ], 'verif_str');

            $delete = VerifStr::where('id', $request->id)->delete();
            if ($delete) {
                File::delete('File/Pegawai/Dokumen/STR/Verifikasi/'.$dokumen->file_verif);
                return response()->json([
                    'message' => 'Data Bukti Verifikasi STR Berhasil Dihapus',
                    'code' => 200,
                ]);
            }else {
                return response()->json([
                    'message' => 'Internal Server Error',
                    'code' => 500,
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'code' => 404,
            ]);
        }
    }

    public function viewPdf($filename)
    {
        // Validasi nama file hanya karakter yang diizinkan (alphanumeric, dash, underscore, dot)
        if (!preg_match('/^[A-Za-z0-9._-]+\.pdf$/', $filename)) {
            abort(404, 'File tidak valid');
        }
        
        $path = public_path('File/Pegawai/Dokumen/STR/Verifikasi/'.$filename);
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
