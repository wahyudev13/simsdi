<?php

namespace App\Http\Controllers;

use App\Models\SpkRkk;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Validator;
use File;
use Auth;
use App\Models\Pegawai;
use App\Models\Departemen;
use App\Helpers\ActivityLogHelper;
class SpkRkkController extends Controller
{

    public function get(Request $request)
    {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }
        $spk = SpkRkk::where('spk_rkk.id_pegawai',$auth)
        ->orderBy('spk_rkk.created_at','desc')
        ->get();

        return DataTables::of($spk)
        ->addColumn('nama', function($spk) {
            return $spk->nama_departemen;
        })
        ->editColumn('updated_at',function($spk) {
            return $spk->updated_at ? $spk->updated_at->format('j F Y h:i:s A') : '';
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required',
            'no_spk' => 'required',
            'dep_spk' => 'required',
            'kualifikasi' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'no_spk.required' => 'Nomor Surat Penugasan Klinik Wajib diisi',
            'dep_spk.required' => 'Departemen Pegawai Wajib diisi',
            'kualifikasi.required' => 'Kualifikasi Pegawai Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {
                $pegawai = Pegawai::find($request->id_pegawai);
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
                $departemen = Departemen::where('dep_id', $request->dep_spk)->first();
                $namaDepartemen = $departemen ? preg_replace('/[^A-Za-z0-9]/', '', $departemen->nama) : 'DEPARTEMEN';
                $nomorSpkBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->no_spk);
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $currentDate = date('Ymd');
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'SPKRKK_' . $namaDepartemen . '_' . $nomorSpkBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Surat-Penugasan-Klinik'), $filenameSimpan);

                $upload = SpkRkk::create([
                    'id_pegawai' => $request->id_pegawai,
                    'nomor_spk' => $request->no_spk,
                    'departemen_id' => $request->dep_spk,
                    'nama_departemen' => $departemen ? $departemen->nama : 'DEPARTEMEN',
                    'kualifikasi' => $request->kualifikasi,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('created', $upload, 'Membuat data SPK RKK baru: ' . $upload->nomor_spk, [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai,
                    'nomor_spk' => $request->no_spk
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Surat Penugasan Klinik '.$request->no_spk.' Berhasil Disimpan',
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
        $dokumen = SpkRkk::where('id', $request->id)->first();
        if ($dokumen) {
            return response()->json([
                'message' => 'Data Ditemukan',
                'code' => 200,
                'data' => [
                    'id' => $dokumen->id,
                    'id_pegawai' => $dokumen->id_pegawai,
                    'nomor_spk' => $dokumen->nomor_spk,
                    'departemen_id' => $dokumen->departemen_id,
                    'kualifikasi' => $dokumen->kualifikasi,
                    'file' => $dokumen->file,
                ]
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
            'id_pegawai' => 'required',
            'no_spk' => 'required',
            'dep_spk' => 'required',
            'kualifikasi' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'no_spk.required' => 'Nomor Surat Penugasan Klinik Wajib diisi',
            'dep_spk.required' => 'Departemen Pegawai Wajib diisi',
            'kualifikasi.required' => 'Kualifikasi Pegawai Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            $spk = SpkRkk::where('id', $request->id)->first();
            $departemen = Departemen::where('dep_id', $request->dep_spk)->first();
            $namaDepartemen = $departemen ? preg_replace('/[^A-Za-z0-9]/', '', $departemen->nama) : 'DEPARTEMEN';
            $pegawai = Pegawai::find($request->id_pegawai);
            $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
            $nomorSpkBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->no_spk);
            $currentDate = date('Ymd');
            if ($request->hasFile('file')) {
                File::delete('File/Pegawai/Dokumen/Surat-Penugasan-Klinik/'.$spk->file);
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'SPKRKK_' . $namaDepartemen . '_' . $nomorSpkBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Surat-Penugasan-Klinik'), $filenameSimpan);
                $upload = SpkRkk::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nomor_spk' => $request->no_spk,
                    'departemen_id' => $request->dep_spk,
                    'nama_departemen' => $departemen ? $departemen->nama : 'DEPARTEMEN',
                    'kualifikasi' => $request->kualifikasi,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('updated', $spk, 'Mengubah data SPK RKK: ' . $spk->nomor_spk, [
                    'nama_file' => $filenameSimpan,
                    'id_pegawai' => $request->id_pegawai,
                    'nomor_spk' => $request->no_spk,
                    'file_diubah' => true
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Surat Penugasan Klinik '.$request->no_spk.' Berhasil Diupdate',
                    'data' => $upload
                ]);
            }else {
                // Generate nama file baru sesuai format terbaru, rename file lama, update field file di database
                $oldFile = $spk->file;
                $pegawai = Pegawai::find($request->id_pegawai);
                $nip = $pegawai ? $pegawai->nik : $request->id_pegawai;
                $nomorSpkBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->no_spk);
                $currentDate = date('Ymd');
                $extension = pathinfo($oldFile, PATHINFO_EXTENSION);
                $hash = substr(md5($oldFile . time()), 0, 6);
                $filenameSimpan = 'SPKRKK_' . $namaDepartemen . '_' . $nomorSpkBersih . '_' . $nip . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $oldPath = public_path('File/Pegawai/Dokumen/Surat-Penugasan-Klinik/'.$oldFile);
                $newPath = public_path('File/Pegawai/Dokumen/Surat-Penugasan-Klinik/'.$filenameSimpan);
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                }
                $upload = SpkRkk::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nomor_spk' => $request->no_spk,
                    'departemen_id' => $request->dep_spk,
                    'nama_departemen' => $departemen ? $departemen->nama : 'DEPARTEMEN',
                    'kualifikasi' => $request->kualifikasi,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('updated', $spk, 'Mengubah data SPK RKK: ' . $spk->nomor_spk, [
                    'id_pegawai' => $request->id_pegawai,
                    'nomor_spk' => $request->no_spk,
                    'file_diubah' => false,
                    'nama_file_baru' => $filenameSimpan,
                    'nama_file_lama' => $oldFile
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Surat Penugasan Klinik '.$request->no_spk.' Berhasil Diupdate',
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
        $dokumen = SpkRkk::where('id', $request->id)->first();
        $delete = SpkRkk::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Surat-Penugasan-Klinik/'.$dokumen->file);
            ActivityLogHelper::log('Menghapus data SPK RKK: ' . ($dokumen->nomor_spk ?? ''), [
                'id_spk' => $dokumen->id ?? null,
                'nama_file' => $dokumen->file ?? null,
                'id_pegawai' => $dokumen->id_pegawai ?? null,
                'nomor_spk' => $dokumen->nomor_spk ?? null
            ]);
            return response()->json([
                'message' => 'Data Surat Penugasan Klinik Berhasil Dihapus',
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
        $path = public_path('File/Pegawai/Dokumen/Surat-Penugasan-Klinik/' . $filename);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
