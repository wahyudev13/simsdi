<?php

namespace App\Http\Controllers;

use App\Models\SpkRkk;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Validator;
use File;
class SpkRkkController extends Controller
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
        $spk = SpkRkk::where('spk_rkk.id_pegawai',$request->id)
        ->join("$database_2.departemen as departemen",'spk_rkk.departemen_id','=','departemen.dep_id')
        ->orderBy('spk_rkk.created_at','desc')
        ->get();

        return DataTables::of($spk)
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
            'no_spk' => 'required',
            'dep_spk' => 'required',
            'kualifikasi' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'no_spk.required' => 'Nomor Surat Penugsan Klinik Wajib diisi',
            'dep_spk.required' => 'Departemen Pegawai Wajib diisi',
            'kualifikasi.required' => 'Kualifikasi Pegawai Wajib diisi',
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
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Surat-Penugasan-Klinik'), $filenameSimpan);
    
                $upload = SpkRkk::create([
                    'id_pegawai' => $request->id_pegawai,
                    'nomor_spk' => $request->no_spk,
                    'departemen_id' => $request->dep_spk,
                    'kualifikasi' => $request->kualifikasi,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Surat Penugsan Klinik '.$request->no_spk.' Berhasil Disimpan',
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
     * @param  \App\Models\SpkRkk  $spkRkk
     * @return \Illuminate\Http\Response
     */
    public function show(SpkRkk $spkRkk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SpkRkk  $spkRkk
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $dokumen = SpkRkk::where('id', $request->id)->first();
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
     * @param  \App\Models\SpkRkk  $spkRkk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required',
            'no_spk' => 'required',
            'dep_spk' => 'required',
            'kualifikasi' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'no_spk.required' => 'Nomor Surat Penugsan Klinik Wajib diisi',
            'dep_spk.required' => 'Departemen Pegawai Wajib diisi',
            'kualifikasi.required' => 'Kualifikasi Pegawai Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = SpkRkk::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/Surat-Penugasan-Klinik/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Surat-Penugasan-Klinik'), $filenameSimpan);
    
                $upload = SpkRkk::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nomor_spk' => $request->no_spk,
                    'departemen_id' => $request->dep_spk,
                    'kualifikasi' => $request->kualifikasi,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Surat Penugsan Klinik '.$request->no_spk.' Berhasil Diupdate',
                    'data' => $upload
                ]);
            }else {
                $upload = SpkRkk::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'nomor_spk' => $request->no_spk,
                    'departemen_id' => $request->dep_spk,
                    'kualifikasi' => $request->kualifikasi
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Surat Penugsan Klinik '.$request->no_spk.' Berhasil Diupdate',
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
     * @param  \App\Models\SpkRkk  $spkRkk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dokumen = SpkRkk::where('id', $request->id)->first();
    
        $delete = SpkRkk::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Surat-Penugasan-Klinik/'.$dokumen->file);
            return response()->json([
                'message' => 'Data Surat Penugsan Klinik Berhasil Dihapus',
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
