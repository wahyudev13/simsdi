<?php

namespace App\Http\Controllers;

use App\Models\FileOrientasi;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\MasterBerkas;
use App\Helpers\ActivityLogHelper;
use Auth;
class FileOrientasiController extends Controller
{
    
    public function getOrientasi(Request $request)
    {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }
        $getfile = FileOrientasi::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'file_orientasi.nama_file_id', '=', 'master_berkas_pegawai.id')
        ->select('master_berkas_pegawai.nama_berkas','file_orientasi.id','file_orientasi.nomor',
        'file_orientasi.tgl_mulai','file_orientasi.tgl_selesai','file_orientasi.file')
        ->get();

        return DataTables::of($getfile)
        ->addIndexColumn()
        ->make(true);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_ori' => 'required',
            'nomor_orientasi' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_ori.required' => 'Nama File wajib Dipilih',
            'nomor_orientasi.required' => 'Nomor Sertifikat Wajib diisi',
            'tgl_mulai.required' => 'Tanggal Mulai Wajib diisi',
            'tgl_selesai.required' => 'Tanggal Selesai Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {
                $pegawai = Pegawai::find($request->id_pegawai);
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
                $nomorBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->nomor_orientasi);
                $masterBerkas = MasterBerkas::find($request->nama_file_ori);
                $namaBerkas = $masterBerkas ? preg_replace('/[^A-Za-z0-9]/', '', $masterBerkas->nama_berkas) : 'DOKUMEN';
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $currentDate = date('Ymd');
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'ORIENTASI_' . $namaBerkas . '_' . $nomorBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Orientasi'), $filenameSimpan);
    
                $upload = FileOrientasi::create([
                    'nama_file_id' => $request->nama_file_ori,
                    'id_pegawai' => $request->id_pegawai,
                    'nomor' => $request->nomor_orientasi,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('created', $upload, 'Membuat data Orientasi baru: ' . $upload->nomor, [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai,
                    'nomor' => $request->nomor_orientasi
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sertifikat Orientasi '.$request->nomor_orientasi.' Berhasil Disimpan',
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
        $dokumen = FileOrientasi::where('id', $request->id)->first();
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
            'nama_file_ori' => 'required',
            'nomor_orientasi' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_ori.required' => 'Nama File wajib Dipilih',
            'nomor_orientasi.required' => 'Nomor Sertifikat Wajib diisi',
            'tgl_mulai.required' => 'Tanggal Mulai Wajib diisi',
            'tgl_selesai.required' => 'Tanggal Selesai Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {
                $delete_file = FileOrientasi::where('id', $request->id_orientasi)->first();
                File::delete('File/Pegawai/Dokumen/Orientasi/'.$delete_file->file);
                $pegawai = Pegawai::find($request->id_pegawai);
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
                $nomorBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->nomor_orientasi);
                $masterBerkas = MasterBerkas::find($request->nama_file_ori);
                $namaBerkas = $masterBerkas ? preg_replace('/[^A-Za-z0-9]/', '', $masterBerkas->nama_berkas) : 'DOKUMEN';
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $currentDate = date('Ymd');
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'ORIENTASI_' . $namaBerkas . '_' . $nomorBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Orientasi'), $filenameSimpan);
    
                $upload = FileOrientasi::where('id', $request->id_orientasi)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_id' => $request->nama_file_ori,
                    'nomor' => $request->nomor_orientasi,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('updated', $delete_file, 'Mengubah data Orientasi: ' . $delete_file->nomor, [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai,
                    'nomor' => $request->nomor_orientasi,
                    'file_diubah' => true
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sertifikat Orientasi '.$request->nomor_orientasi.' Berhasil Diupdate',
                    'data' => $upload
                ]);
            }else {
                $ori = FileOrientasi::where('id', $request->id_orientasi)->first();
                $pegawai = Pegawai::find($request->id_pegawai);
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
                $nomorBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->nomor_orientasi);
                $masterBerkas = MasterBerkas::find($request->nama_file_ori);
                $namaBerkas = $masterBerkas ? preg_replace('/[^A-Za-z0-9]/', '', $masterBerkas->nama_berkas) : 'DOKUMEN';
                $currentDate = date('Ymd');
                $extension = pathinfo($ori->file, PATHINFO_EXTENSION);
                $hash = substr(md5($ori->file . time()), 0, 6);
                $filenameSimpan = 'ORIENTASI_' . $namaBerkas . '_' . $nomorBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $oldPath = public_path('File/Pegawai/Dokumen/Orientasi/'.$ori->file);
                $newPath = public_path('File/Pegawai/Dokumen/Orientasi/'.$filenameSimpan);
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                }
                $upload = FileOrientasi::where('id', $request->id_orientasi)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_id' => $request->nama_file_ori,
                    'nomor' => $request->nomor_orientasi,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('updated', $ori, 'Mengubah data Orientasi: ' . $ori->nomor, [
                    'id_pegawai' => $request->id_pegawai,
                    'nomor' => $request->nomor_orientasi,
                    'file_diubah' => false,
                    'nama_file_baru' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sertifikat Orientasi '.$request->nomor_orientasi.' Berhasil Diupdate',
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
        $delete_file = FileOrientasi::where('id', $request->id_orientasi)->first();

        $delete = FileOrientasi::where('id', $request->id_orientasi)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Orientasi/'.$delete_file->file);
            ActivityLogHelper::log('Menghapus data Orientasi: ' . ($delete_file->nomor ?? ''), [
                'id_orientasi' => $delete_file->id ?? null,
                'nama_file' => $delete_file->file ?? null,
                'id_pegawai' => $delete_file->id_pegawai ?? null,
                'nomor' => $delete_file->nomor ?? null
            ]);
            return response()->json([
                'message' => 'Data Sertifikat '.$request->nomor.' Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
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
        $path = public_path('File/Pegawai/Dokumen/Orientasi/' . $filename);
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
