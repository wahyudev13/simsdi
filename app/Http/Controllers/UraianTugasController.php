<?php

namespace App\Http\Controllers;

use App\Models\UraianTugas;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Validator;
use File;

class UraianTugasController extends Controller
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

    public function get(Request $request) {

        $database_2 = config('database.connections.mysql2.database');
        $uraian_tugas = UraianTugas::where('uraian_tugas.id_pegawai',$request->id)
        ->join("$database_2.departemen as departemen",'uraian_tugas.departemen_id','=','departemen.dep_id')
        ->orderBy('uraian_tugas.created_at','desc')
        ->get();

        return DataTables::of($uraian_tugas)
        ->editColumn('updated_at',function($spk) {
            return $spk->updated_at->format('j F Y h:i:s A');
        })
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

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Uraian-Tugas'), $filenameSimpan);
    
                $upload = UraianTugas::create([
                    'id_pegawai' => $request->id_pegawai,
                    'departemen_id' => $request->dep_uraian,
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UraianTugas  $uraianTugas
     * @return \Illuminate\Http\Response
     */
    public function show(UraianTugas $uraianTugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UraianTugas  $uraianTugas
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UraianTugas  $uraianTugas
     * @return \Illuminate\Http\Response
     */
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
            if ($request->hasFile('file')) {

                $delete_file = UraianTugas::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/Uraian-Tugas/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Uraian-Tugas'), $filenameSimpan);
    
                $update = UraianTugas::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'departemen_id' => $request->dep_uraian,
                    'jabatan' => $request->jabatan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Uraian Tugas '.$request->jabatan.' Berhasil Diupdate',
                    'data' => $update
                ]);
            }else {
                $update = UraianTugas::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'departemen_id' => $request->dep_uraian,
                    'jabatan' => $request->jabatan,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UraianTugas  $uraianTugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dokumen = UraianTugas::where('id', $request->id)->first();
    
        $delete = UraianTugas::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Uraian-Tugas/'.$dokumen->file);
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
}
