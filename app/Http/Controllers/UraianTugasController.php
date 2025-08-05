<?php

namespace App\Http\Controllers;

use App\Models\UraianTugas;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Validator;
use File;
use Illuminate\Support\Facades\Auth;
use App\Models\Departemen;
use App\Helpers\ActivityLogHelper;
use App\Models\Pegawai;
class UraianTugasController extends Controller
{
    

    public function get(Request $request) 
    {
        if (auth('admin')->check()) {
            $auth = $request->id;
        } else {
            $auth = Auth::user()->id_pegawai;
        }
        $uraian_tugas = UraianTugas::where('uraian_tugas.id_pegawai',$auth)
        ->orderBy('uraian_tugas.created_at','desc')
        ->get();

        return DataTables::of($uraian_tugas)
        ->editColumn('updated_at',function($spk) {
            return $spk->updated_at->format('j F Y h:i:s A');
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required',
            'dep_uraian' => 'required',
            'jabatan' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'dep_uraian.required' => 'Departemen / Unit Kerja Pegawai Wajib diisi',
            'jabatan.required' => 'Jabatan Pegawai Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {
                $departemen = Departemen::where('dep_id', $request->dep_uraian)->first();
                $nama_departemen = $departemen ? $departemen->nama : null;
                $namaDepartemenBersih = $departemen ? preg_replace('/[^A-Za-z0-9]/', '', $departemen->nama) : 'DEPARTEMEN';
                $jabatanBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->jabatan);
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();
                $nipPegawai = $pegawai ? $pegawai->nik : $request->id_pegawai;
                $currentDate = date('Ymd');
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'URAIANTUGAS_' . $namaDepartemenBersih . '_' . $jabatanBersih . '_' . $nipPegawai . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Uraian-Tugas'), $filenameSimpan);
    
                $upload = UraianTugas::create([
                    'id_pegawai' => $request->id_pegawai,
                    'departemen_id' => $request->dep_uraian,
                    'nama_departemen' => $nama_departemen,
                    'jabatan' => $request->jabatan,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('created', $upload, 'Membuat data Uraian Tugas baru: '.$request->jabatan, [
                    'id_pegawai' => $request->id_pegawai,
                    'departemen_id' => $request->dep_uraian,
                    'nama_departemen' => $nama_departemen,
                    'jabatan' => $request->jabatan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Uraian Tugas '.$request->jabatan.' Berhasil Disimpan',
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
        
        $dokumen = UraianTugas::where('id', $request->id)->first();
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
            'id_pegawai' => 'required',
            'dep_uraian' => 'required',
            'jabatan' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'dep_uraian.required' => 'Departemen / Unit Kerja Pegawai Wajib diisi',
            'jabatan.required' => 'Jabatan Pegawai Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            $departemen = Departemen::where('dep_id', $request->dep_uraian)->first();
            $nama_departemen = $departemen ? $departemen->nama : null;
            $namaDepartemenBersih = $departemen ? preg_replace('/[^A-Za-z0-9]/', '', $departemen->nama) : 'DEPARTEMEN';
            $jabatanBersih = preg_replace('/[^A-Za-z0-9]/', '', $request->jabatan);
            $pegawai = Pegawai::where('id', $request->id_pegawai)->first();
            $nipPegawai = $pegawai ? $pegawai->nik : $request->id_pegawai;
            $currentDate = date('Ymd');
            if ($request->hasFile('file')) {
                $delete_file = UraianTugas::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/Uraian-Tugas/'.$delete_file->file);
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $extension = $request->file('file')->getClientOriginalExtension();
                $hash = substr(md5($filenameWithExt . time()), 0, 6);
                $filenameSimpan = 'URAIANTUGAS_' . $namaDepartemenBersih . '_' . $jabatanBersih . '_' . $nipPegawai . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Uraian-Tugas'), $filenameSimpan);
    
                $update = UraianTugas::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'departemen_id' => $request->dep_uraian,
                    'nama_departemen' => $nama_departemen,
                    'jabatan' => $request->jabatan,
                    'file' => $filenameSimpan
                ]);
                ActivityLogHelper::logCrud('updated', $delete_file, 'Mengubah data Uraian Tugas: '.$request->jabatan, [
                    'id_pegawai' => $request->id_pegawai,
                    'departemen_id' => $request->dep_uraian,
                    'nama_departemen' => $nama_departemen,
                    'jabatan' => $request->jabatan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Uraian Tugas '.$request->jabatan.' Berhasil Diupdate',
                    'data' => $update
                ]);
            }else {
                // Rename file lama sesuai format baru meskipun file tidak diupload
                $dokumen = UraianTugas::where('id', $request->id)->first();
                $oldFile = $dokumen->file;
                $extension = pathinfo($oldFile, PATHINFO_EXTENSION);
                $hash = substr(md5($oldFile . time()), 0, 6);
                $filenameSimpan = 'URAIANTUGAS_' . $namaDepartemenBersih . '_' . $jabatanBersih . '_' . $nipPegawai . '_' . $currentDate . '_' . $hash . '.' . $extension;
                $oldPath = public_path('File/Pegawai/Dokumen/Uraian-Tugas/'.$oldFile);
                $newPath = public_path('File/Pegawai/Dokumen/Uraian-Tugas/'.$filenameSimpan);
                if (file_exists($oldPath)) {
                    rename($oldPath, $newPath);
                }
                $update = UraianTugas::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'departemen_id' => $request->dep_uraian,
                    'nama_departemen' => $nama_departemen,
                    'jabatan' => $request->jabatan,
                    'file' => $filenameSimpan
                ]);
                $dokumen = UraianTugas::where('id', $request->id)->first();
                ActivityLogHelper::logCrud('updated', $dokumen, 'Mengubah data Uraian Tugas: '.$request->jabatan, [
                    'id_pegawai' => $request->id_pegawai,
                    'departemen_id' => $request->dep_uraian,
                    'nama_departemen' => $nama_departemen,
                    'jabatan' => $request->jabatan,
                    'file' => $filenameSimpan,
                    'file_diubah' => false,
                    'nama_file_baru' => $filenameSimpan,
                    'nama_file_lama' => $oldFile
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Uraian Tugas '.$request->jabatan.' Berhasil Diupdate',
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
        $dokumen = UraianTugas::where('id', $request->id)->first();
    
        $delete = UraianTugas::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Uraian-Tugas/'.$dokumen->file);
            ActivityLogHelper::log('Menghapus data Uraian Tugas: ' . ($dokumen->jabatan ?? ''), [
                'id_pegawai' => $dokumen->id_pegawai ?? null,
                'departemen_id' => $dokumen->departemen_id ?? null,
                'nama_departemen' => $dokumen->nama_departemen ?? null,
                'jabatan' => $dokumen->jabatan ?? null,
                'file' => $dokumen->file ?? null
            ]);
            return response()->json([
                'message' => 'Data Uraian-Tugas Berhasil Dihapus',
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
        $path = public_path('File/Pegawai/Dokumen/Uraian-Tugas/' . $filename);
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
