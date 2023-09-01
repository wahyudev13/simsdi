<?php

namespace App\Http\Controllers;

use App\Models\FileLain;
use App\Models\MasterBerkas;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FileLainController extends Controller
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

    public function get(Request $request)
    {
        $getfile = FileLain::where('id_pegawai', $request->id)
        ->join('master_berkas_pegawai', 'file_lain.nama_file_id', '=', 'master_berkas_pegawai.id')
        ->select('master_berkas_pegawai.nama_berkas','file_lain.id','file_lain.file')
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

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Lain'), $filenameSimpan);
    
                $upload = FileLain::create([
                    'id_pegawai' => $request->id_pegawai,
                    'nama_file_id' => $request->nama_file_id_lainlain,
                    'file' => $filenameSimpan
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileLain  $fileLain
     * @return \Illuminate\Http\Response
     */
    public function show(FileLain $fileLain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileLain  $fileLain
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileLain  $fileLain
     * @return \Illuminate\Http\Response
     */
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

                $delete_file = FileLain::where('id', $request->id_lain)->first();
                File::delete('File/Pegawai/Dokumen/Lain/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Lain'), $filenameSimpan);
    
                $upload = FileLain::where('id', $request->id_lain)->update([
                    // 'id_pegawai' => $request->id_pegawai,
                    'nama_file_id' => $request->nama_file_id_lainlain,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas->nama_berkas.' Berhasil Diupdate',
                    'data' => $upload
                ]);
            }else {
                $master_berkas = MasterBerkas::where('id', $request->nama_file_id_lainlain)->first();
                $upload = FileLain::where('id', $request->id_lain)->update([
                    // 'id_pegawai' => $request->id_pegawai,
                    'nama_file_id' => $request->nama_file_id_lainlain,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileLain  $fileLain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dokumen = FileLain::where('id', $request->id)->first();

        $delete = FileLain::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Lain/'.$dokumen->file);
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
}
