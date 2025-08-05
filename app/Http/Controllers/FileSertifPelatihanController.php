<?php

namespace App\Http\Controllers;

use App\Models\FileSertifPelatihan;
use App\Models\MasterBerkas;
use App\Models\Pegawai;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogHelper;

class FileSertifPelatihanController extends Controller
{
    public function get(Request $request) 
    {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }
        $get = FileSertifPelatihan::where('id_pegawai', $auth)
        ->join('master_berkas_pegawai', 'sertif_pelatihan.berkas_id', '=', 'master_berkas_pegawai.id')
        ->select('sertif_pelatihan.id','sertif_pelatihan.berkas_id','sertif_pelatihan.id_pegawai','sertif_pelatihan.nm_kegiatan','sertif_pelatihan.tgl_kegiatan',
        'sertif_pelatihan.tmp_kegiatan','sertif_pelatihan.penyelenggara','sertif_pelatihan.file','master_berkas_pegawai.nama_berkas')
        ->get();

        return DataTables::of($get)
        ->addIndexColumn()
        ->make(true);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            // 'id_pegawai' => 'required',
            'berkas_id' => 'required',
            'nm_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'tmp_kegiatan' => 'required',
            'penye_kegiatan' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            // 'id_pegawai.required' => 'Nama File Wajib diisi',
            'berkas_id.required' => 'Jenis Sertifikat Pelatihan Wajib Dipilih',
            'nm_kegiatan.required' => 'Nama Kegiatan / Pelatihan Wajib diisi',
            'tgl_kegiatan.required' => 'Tanggal Kegiatan / Pelatihan Wajib diisi',
            'tmp_kegiatan.required' => 'Tempat Kegiatan / Pelatihan Wajib diisi',
            'penye_kegiatan.required' => 'Penyelenggara Kegiatan / Pelatihan Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();

                // Penamaan file baru
                $nama_kegiatan = $request->nm_kegiatan ? strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $request->nm_kegiatan)) : 'kegiatan';
                $tgl_kegiatan = $request->tgl_kegiatan ? preg_replace('/[^0-9]/', '', $request->tgl_kegiatan) : date('Ymd');
                $nip = $pegawai && isset($pegawai->nik) ? $pegawai->nik : 'NIP';
                $timestamp = time();
                $hash = substr(md5($nama_kegiatan . $tgl_kegiatan . $nip . $timestamp), 0, 8);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = 'SERTIFIKAT-' . $nama_kegiatan . '-' . $tgl_kegiatan . '-' . $nip . '-' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Diklat/Sertifikat-Pelatihan'), $filenameSimpan);
    
                $store = FileSertifPelatihan::create([
                    'id_pegawai' => $request->id_pegawai,
                    'berkas_id' => $request->berkas_id,
                    'nm_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan,
                    'tmp_kegiatan' => $request->tmp_kegiatan,
                    'penyelenggara' => $request->penye_kegiatan,
                    'file' => $filenameSimpan
                ]);
                // Log aktivitas
                ActivityLogHelper::logCrud('created', $store, 'Menambah Sertifikat Pelatihan: ' . $filenameSimpan, [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai,
                    'nama_berkas' => $master_berkas_kompetensi->nama_berkas ?? null,
                    'nama_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$request->nm_kegiatan.' '.$pegawai->nama.' Berhasil Disimpan',
                    'data' => $store
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
        $dokumen = FileSertifPelatihan::where('id', $request->id)->first();
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
            // 'id_pegawai' => 'required',
            'berkas_id' => 'required',
            'nm_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'tmp_kegiatan' => 'required',
            'penye_kegiatan' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            // 'id_pegawai.required' => 'Nama File Wajib diisi',
            'berkas_id.required' => 'Jenis Sertifikat Pelatihan Wajib Dipilih',
            'nm_kegiatan.required' => 'Nama Kegiatan / Pelatihan Wajib diisi',
            'tgl_kegiatan.required' => 'Tanggal Kegiatan / Pelatihan Wajib diisi',
            'tmp_kegiatan.required' => 'Tempat Kegiatan / Pelatihan Wajib diisi',
            'penye_kegiatan.required' => 'Penyelenggara Kegiatan / Pelatihan Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileSertifPelatihan::where('id', $request->id)->first();
                File::delete('File/Pegawai/Diklat/Sertifikat-Pelatihan/'.$delete_file->file);

                $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();

                // Penamaan file baru
                $nama_kegiatan = $request->nm_kegiatan ? strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $request->nm_kegiatan)) : 'kegiatan';
                $tgl_kegiatan = $request->tgl_kegiatan ? preg_replace('/[^0-9]/', '', $request->tgl_kegiatan) : date('Ymd');
                $nip = $pegawai && isset($pegawai->nik) ? $pegawai->nik : 'NIP';
                $timestamp = time();
                $hash = substr(md5($nama_kegiatan . $tgl_kegiatan . $nip . $timestamp), 0, 8);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = 'SERTIFIKAT-' . $nama_kegiatan . '-' . $tgl_kegiatan . '-' . $nip . '-' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Diklat/Sertifikat-Pelatihan'), $filenameSimpan);
    
                $update = FileSertifPelatihan::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'berkas_id' => $request->berkas_id,
                    'nm_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan,
                    'tmp_kegiatan' => $request->tmp_kegiatan,
                    'penyelenggara' => $request->penye_kegiatan,
                    'file' => $filenameSimpan
                ]);
                // Log aktivitas
                ActivityLogHelper::logCrud('updated', $delete_file, 'Mengubah Sertifikat Pelatihan: ' . $filenameSimpan, [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai,
                    'nama_berkas' => $master_berkas_kompetensi->nama_berkas ?? null,
                    'nama_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$pegawai->nama.' Berhasil Diupdate',
                    'data' => $update
                ]);
            }else {
                $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();
                
                // Penamaan file baru
                $sertifikat = FileSertifPelatihan::where('id', $request->id)->first();
                $nama_kegiatan = $request->nm_kegiatan ? strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $request->nm_kegiatan)) : 'kegiatan';
                $tgl_kegiatan = $request->tgl_kegiatan ? preg_replace('/[^0-9]/', '', $request->tgl_kegiatan) : date('Ymd');
                $nip = $pegawai && isset($pegawai->nik) ? $pegawai->nik : 'NIP';
                $timestamp = time();
                $hash = substr(md5($nama_kegiatan . $tgl_kegiatan . $nip . $timestamp), 0, 8);
                $newFilename = 'SERTIFIKAT-' . $nama_kegiatan . '-' . $tgl_kegiatan . '-' . $nip . '-' . $hash . '.' . pathinfo($sertifikat->file, PATHINFO_EXTENSION);
                // Rename file lama ke nama baru setiap kali update
                $oldPath = public_path('File/Pegawai/Diklat/Sertifikat-Pelatihan/' . $sertifikat->file);
                $newPath = public_path('File/Pegawai/Diklat/Sertifikat-Pelatihan/' . $newFilename);
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                    $filenameSimpan = $newFilename;
                } else {
                    $filenameSimpan = $sip->file;
                }
                $update = FileSertifPelatihan::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'berkas_id' => $request->berkas_id,
                    'nm_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan,
                    'tmp_kegiatan' => $request->tmp_kegiatan,
                    'penyelenggara' => $request->penye_kegiatan,
                    'file' => $filenameSimpan // update nama file di database
                ]);
                // Log aktivitas
                $ori = FileSertifPelatihan::where('id', $request->id)->first();
                ActivityLogHelper::logCrud('updated', $ori, 'Mengubah Sertifikat Pelatihan (rename file): ' . ($filenameSimpan ?? ''), [
                    'id_pegawai' => $request->id_pegawai,
                    'nama_berkas' => $master_berkas_kompetensi->nama_berkas ?? null,
                    'nama_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan,
                    'nama_file_baru' => $filenameSimpan ?? null,
                    'nama_file_lama' => $sertifikat->file ?? null
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$pegawai->nama.' Berhasil Diupdate',
                    'data' => $update
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
        $dokumen = FileSertifPelatihan::where('id', $request->id)->first();
        $delete_file = FileSertifPelatihan::where('id', $request->id)->delete();

        $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
        $pegawai = Pegawai::where('id', $request->id_pegawai)->first();
        
        if ($delete_file) {
            File::delete('File/Pegawai/Diklat/Sertifikat-Pelatihan/'.$dokumen->file);
            // Log aktivitas
            ActivityLogHelper::log('Menghapus Sertifikat Pelatihan: ' . ($dokumen->file ?? ''), [
                'id_pegawai' => $request->id_pegawai,
                'nama_berkas' => $master_berkas_kompetensi->nama_berkas ?? null,
                'nama_kegiatan' => $dokumen->nm_kegiatan ?? null,
                'tgl_kegiatan' => $dokumen->tgl_kegiatan ?? null
            ]);
            return response()->json([
                'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$pegawai->nama.' Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data',
                'code' => 500,
            ]);
        }
    }

    /**
     * Menampilkan file sertifikat pelatihan via controller (stream PDF)
     */
    public function viewFile($filename)
    {
        // Validasi nama file hanya karakter yang diizinkan (alphanumeric, dash, underscore, dot)
        if (!preg_match('/^[A-Za-z0-9._-]+\.pdf$/', $filename)) {
            abort(404, 'File tidak valid');
        }
        $path = public_path('File/Pegawai/Diklat/Sertifikat-Pelatihan/' . $filename);
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
