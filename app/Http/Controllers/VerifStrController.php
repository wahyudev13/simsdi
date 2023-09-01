<?php

namespace App\Http\Controllers;

use App\Models\VerifStr;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerifStrController extends Controller
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
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'file.required' => 'File Bukti Verifikasi Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);
        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/STR/Verifikasi'), $filenameSimpan);
    
                $upload = VerifStr::create([
                    'str_id' => $request->str_id,
                    'file_verif' => $filenameSimpan,
                    'keterangan' => $request->ket_bukti
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Bukti Verifikasi STR Berhasil Disimpan',
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
     * @param  \App\Models\VerifStr  $verifStr
     * @return \Illuminate\Http\Response
     */
    public function show(VerifStr $verifStr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VerifStr  $verifStr
     * @return \Illuminate\Http\Response
     */
    public function edit(VerifStr $verifStr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VerifStr  $verifStr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VerifStr $verifStr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VerifStr  $verifStr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dokumen = VerifStr::where('id', $request->id)->first();
    
        $delete = VerifStr::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/STR/Verifikasi/'.$dokumen->file_verif);
            return response()->json([
                'message' => 'Data Bukti Verifikasi STR Berhasil Dihapus',
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
