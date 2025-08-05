<?php

namespace App\Http\Controllers;

use App\Models\FileLain;
use App\Models\MasterBerkas;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ActivityLogHelper;
use App\Models\Pegawai;
class FileLainController extends Controller
{

    public function get(Request $request)
    {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }
        $getfile = FileLain::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_lain.nama_file_id', '=', 'master_berkas_pegawai.id')
        ->select('master_berkas_pegawai.nama_berkas','file_lain.id','file_lain.file')
        ->get();

        return DataTables::of($getfile)
        ->addIndexColumn()
        ->make(true);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_id_lainlain' => 'required',
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ],[
            'nama_file_id_lainlain.required' => 'Nama File Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf,jpg,jpeg,png',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {
                $master_berkas = MasterBerkas::where('id', $request->nama_file_id_lainlain)->first();
                $pegawai = Pegawai::find($request->id_pegawai);
                // NIP diambil dari field nik pada tabel pegawai
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
                $namaBerkas = $master_berkas ? preg_replace('/[^A-Za-z0-9]/', '', $master_berkas->nama_berkas) : 'DOKUMEN';
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $currentDate = date('Ymd');
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'BERKASLAIN_' . $namaBerkas . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Lain'), $filenameSimpan);
    
                $upload = FileLain::create([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_id' => $request->nama_file_id_lainlain,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('created', $upload, 'Membuat data Berkas Lain: ' . $filenameSimpan, [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai,
                    'nama_berkas' => $master_berkas->nama_berkas ?? null,
                    'nip' => $nip
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas->nama_berkas.' Berhasil Disimpan',
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
        $dokumen = FileLain::where('id', $request->id)->first();
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
            'nama_file_id_lainlain' => 'required',
            'file' => 'mimes:pdf,jpg,jpeg,png|max:2048',
        ],[
            'nama_file_id_lainlain.required' => 'Nama File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf,jpg,jpeg,png',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {
                $master_berkas = MasterBerkas::where('id', $request->nama_file_id_lainlain)->first();
                $pegawai = Pegawai::find($request->id_pegawai);
                // NIP diambil dari field nik pada tabel pegawai
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
                $namaBerkas = $master_berkas ? preg_replace('/[^A-Za-z0-9]/', '', $master_berkas->nama_berkas) : 'DOKUMEN';
                $delete_file = FileLain::where('id', $request->id_lain)->first();
                File::delete('File/Pegawai/Dokumen/Lain/'.$delete_file->file);
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $currentDate = date('Ymd');
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'BERKASLAIN_' . $namaBerkas . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Lain'), $filenameSimpan);
    
                $upload = FileLain::where('id', $request->id_lain)->update([
                    'nama_file_id' => $request->nama_file_id_lainlain,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('updated', $delete_file, 'Mengubah data Berkas Lain: ' . $filenameSimpan, [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai,
                    'nama_berkas' => $master_berkas->nama_berkas ?? null,
                    'file_diubah' => true,
                    'nip' => $nip
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas->nama_berkas.' Berhasil Diupdate',
                    'data' => $upload
                ]);
            }else {
                $master_berkas = MasterBerkas::where('id', $request->nama_file_id_lainlain)->first();
                $upload = FileLain::where('id', $request->id_lain)->update([
                    'nama_file_id' => $request->nama_file_id_lainlain,
                ]);
                $ori = FileLain::where('id', $request->id_lain)->first();
                $pegawai = Pegawai::find($request->id_pegawai);
                // NIP diambil dari field nik pada tabel pegawai
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
                ActivityLogHelper::logCrud('updated', $ori, 'Mengubah data Berkas Lain tanpa ubah file: ' . ($ori->file ?? ''), [
                    'id_pegawai' => $request->id_pegawai,
                    'nama_berkas' => $master_berkas->nama_berkas ?? null,
                    'file_diubah' => false,
                    'nip' => $nip
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas->nama_berkas.' Berhasil Diupdate',
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
        $dokumen = FileLain::where('id', $request->id)->first();
        $delete = FileLain::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Lain/'.$dokumen->file);
            ActivityLogHelper::log('Menghapus data Berkas Lain: ' . ($dokumen->file ?? ''), [
                'id_lain' => $dokumen->id ?? null,
                'nama_file' => $dokumen->file ?? null,
                'id_pegawai' => $dokumen->id_pegawai ?? null,
                'nama_berkas' => $dokumen->nama_file_id ?? null
            ]);
            return response()->json([
                'message' => 'Data '.$request->nama.' Berhasil Dihapus',
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
        // Validasi nama file hanya karakter yang diizinkan (alphanumeric, dash, underscore, dot)
        if (!preg_match('/^[A-Za-z0-9._-]+\.(pdf|jpg|jpeg|png)$/', $filename)) {
            abort(404, 'File tidak valid');
        }
        $path = public_path('File/Pegawai/Dokumen/Lain/' . $filename);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        // Opsi: tambahkan validasi hak akses user di sini
        $mime = mime_content_type($path);
        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
