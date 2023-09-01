<?php

namespace App\Http\Controllers;

use App\Models\FileOrientasi;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FileOrientasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getOrientasi(Request $request)
    {
        $getfile = FileOrientasi::where('id_pegawai', $request->id)
        ->join('master_berkas_pegawai', 'file_orientasi.nama_file_id', '=', 'master_berkas_pegawai.id')
        ->select('master_berkas_pegawai.nama_berkas','file_orientasi.id','file_orientasi.nomor',
        'file_orientasi.tgl_mulai','file_orientasi.tgl_selesai','file_orientasi.file')
        ->get();

        return DataTables::of($getfile)
        ->addIndexColumn()
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Orientasi'), $filenameSimpan);
    
                $upload = FileOrientasi::create([
                    'nama_file_id' => $request->nama_file_ori,
                    'id_pegawai' => $request->id_pegawai,
                    'nomor' => $request->nomor_orientasi,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sertifikat Oriantasi '.$request->nomor_orientasi.' Berhasil Disimpan',
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileOrientasi  $fileOrientasi
     * @return \Illuminate\Http\Response
     */
    public function show(FileOrientasi $fileOrientasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileOrientasi  $fileOrientasi
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileOrientasi  $fileOrientasi
     * @return \Illuminate\Http\Response
     */
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

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Orientasi'), $filenameSimpan);
    
                $upload = FileOrientasi::where('id', $request->id_orientasi)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_id' => $request->nama_file_ori,
                    'nomor' => $request->nomor_orientasi,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sertifikat Oriantasi '.$request->nomor_orientasi.' Berhasil Diupdate',
                    'data' => $upload
                ]);
            }else {
                $upload = FileOrientasi::where('id', $request->id_orientasi)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_id' => $request->nama_file_ori,
                    'nomor' => $request->nomor_orientasi,
                    'tgl_mulai' => $request->tgl_mulai,
                    'tgl_selesai' => $request->tgl_selesai,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sertifikat Oriantasi '.$request->nomor_orientasi.' Berhasil Diupdate',
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileOrientasi  $fileOrientasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_file = FileOrientasi::where('id', $request->id_orientasi)->first();

        $delete = FileOrientasi::where('id', $request->id_orientasi)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Orientasi/'.$delete_file->file);
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
}
