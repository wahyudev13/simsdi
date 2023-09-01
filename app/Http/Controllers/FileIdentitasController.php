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


class FileIdentitasController extends Controller
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

    public function getFile(Request $request)
    {
        $getfile = FileIdentitas::where('id_pegawai', $request->id)
        ->join('master_berkas_pegawai', 'file_identitas.nama_file_lain_id', '=', 'master_berkas_pegawai.id')
        ->select('master_berkas_pegawai.nama_berkas','file_identitas.id','file_identitas.file')
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

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Identitas'), $filenameSimpan);
    
                $upload = FileIdentitas::create([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_lain_id' => $request->nama_file_lain_id,
                    'file' => $filenameSimpan
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileIdentitas  $FileIdentitas
     * @return \Illuminate\Http\Response
     */
    public function show(FileIdentitas $FileIdentitas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileIdentitas  $FileIdentitas
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileIdentitas  $FileIdentitas
     * @return \Illuminate\Http\Response
     */
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
            if ($request->hasFile('file')) {

                $delete_file = FileIdentitas::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/Identitas/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Identitas'), $filenameSimpan);
    
                $upload = FileIdentitas::where('id', $request->id)->update([
                    'nama_file_lain_id' => $request->nama_file_lain_id,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Berhasil Diupdate',
                    'data' => $upload
                ]);
            }else {
                $upload = FileIdentitas::where('id', $request->id)->update([
                    'nama_file_lain_id' => $request->nama_file_lain_id,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileIdentitas  $FileIdentitas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dokumen = FileIdentitas::where('id', $request->id)->first();

        $delete = FileIdentitas::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Identitas/'.$dokumen->file);
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
}
