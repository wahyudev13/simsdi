<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use App\Models\FileIdentitas;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Auth;
use App\Helpers\ActivityLogHelper;

class FileIdentitasController extends Controller
{

    public function getFile(Request $request)
    {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }

        $getfile = FileIdentitas::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_identitas.nama_file_lain_id', '=', 'master_berkas_pegawai.id')
        ->select('master_berkas_pegawai.nama_berkas','file_identitas.id','file_identitas.file')
        ->get();

        return DataTables::of($getfile)
        ->addIndexColumn()
        ->make(true);
    }

    
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_lain_id' => 'required',
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ],[
            'nama_file_lain_id.required' => 'Nama File Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf,jpg,jpeg,png',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {
                $pegawai = Pegawai::find($request->id_pegawai);
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
                $masterBerkas = MasterBerkas::find($request->nama_file_lain_id);
                $namaBerkas = $masterBerkas ? preg_replace('/[^A-Za-z0-9]/', '', $masterBerkas->nama_berkas) : 'DOKUMEN';
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $currentDate = date('Ymd');
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'IDENTITAS_' . $namaBerkas . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Identitas'), $filenameSimpan);
    
                $upload = FileIdentitas::create([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_lain_id' => $request->nama_file_lain_id,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('created', $upload, 'Membuat data Identitas baru', [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Berhasil Disimpan',
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

    public function edit(Request $request)
    {
        $dokumen = FileIdentitas::where('id', $request->id)->first();
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

    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_lain_id' => 'required',
            'file' => 'mimes:pdf,jpg,jpeg,png|max:2048',
        ],[
            'nama_file_lain_id.required' => 'Nama File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf,jpg,jpeg,png',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            $dokumen = FileIdentitas::where('id', $request->id)->first();
            $pegawai = Pegawai::find($request->id_pegawai);
            $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
            $masterBerkas = MasterBerkas::find($request->nama_file_lain_id);
            $namaBerkas = $masterBerkas ? preg_replace('/[^A-Za-z0-9]/', '', $masterBerkas->nama_berkas) : 'DOKUMEN';
            $currentDate = date('Ymd');
            $hash = substr(md5(($request->hasFile('file') ? $request->file('file')->getClientOriginalName() : $dokumen->file) . time()), 0, 6);
            $extension = $request->hasFile('file') ? $request->file('file')->getClientOriginalExtension() : pathinfo($dokumen->file, PATHINFO_EXTENSION);
            $filenameSimpan = 'IDENTITAS_' . $namaBerkas . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;

            if ($request->hasFile('file')) {
                // Hapus file lama
                File::delete('File/Pegawai/Dokumen/Identitas/'.$dokumen->file);
                // Simpan file baru
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Identitas'), $filenameSimpan);
                $upload = FileIdentitas::where('id', $request->id)->update([
                    'nama_file_lain_id' => $request->nama_file_lain_id,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('updated', $dokumen, 'Mengubah data Identitas', [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai,
                    'file_diubah' => true
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Berhasil Diupdate',
                    'data' => $upload
                ]);
            } else {
                // Rename file lama ke nama baru
                $oldPath = public_path('File/Pegawai/Dokumen/Identitas/' . $dokumen->file);
                $newPath = public_path('File/Pegawai/Dokumen/Identitas/' . $filenameSimpan);
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                }
                $upload = FileIdentitas::where('id', $request->id)->update([
                    'nama_file_lain_id' => $request->nama_file_lain_id,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('updated', $dokumen, 'Mengubah data Identitas', [
                    'id_pegawai' => $request->id_pegawai,
                    'file_diubah' => false,
                    'nama_file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Berhasil Diupdate',
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
        $dokumen = FileIdentitas::where('id', $request->id)->first();
        $delete = FileIdentitas::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Identitas/'.$dokumen->file);
            ActivityLogHelper::log('Menghapus data Identitas', [
                'id_identitas' => $dokumen->id ?? null,
                'nama_file' => $dokumen->file ?? null,
                'id_pegawai' => $dokumen->id_pegawai ?? null
            ]);
            return response()->json([
                'message' => 'Data Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }

    public function viewPdf($filename)
    {
        // Validasi nama file hanya karakter yang diizinkan
        if (!preg_match('/^[A-Za-z0-9._-]+\.(pdf|jpg|jpeg|png)$/', $filename)) {
            abort(404, 'File tidak valid');
        }
        $path = public_path('File/Pegawai/Dokumen/Identitas/' . $filename);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        
        // Tentukan Content-Type berdasarkan ekstensi file
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $contentType = 'application/octet-stream';
        
        switch ($extension) {
            case 'pdf':
                $contentType = 'application/pdf';
                break;
            case 'jpg':
            case 'jpeg':
                $contentType = 'image/jpeg';
                break;
            case 'png':
                $contentType = 'image/png';
                break;
        }
        
        return response()->file($path, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
