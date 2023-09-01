<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\MasterBerkas;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;

class FileTranskripController extends Controller
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

    public function getTranskrip(Request $request)
    {
        $gettranskrip = FileTranskrip::where('id_pegawai', $request->id)
        ->join('master_berkas_pegawai', 'file_transkrip.nama_file_trans_id', '=', 'master_berkas_pegawai.id')
        ->select('file_transkrip.id','file_transkrip.nomor_transkrip','file_transkrip.file','master_berkas_pegawai.nama_berkas',
        'file_transkrip.updated_at')
        ->get();
        return DataTables::of($gettranskrip)
        ->editColumn('updated_at',function($gettranskrip) {
            return $gettranskrip->updated_at->format('j F Y h:i:s A');
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
            'nama_file_trans_id' => 'required',
            'nomor_transkrip' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_trans_id.required' => 'Nama File Wajib diisi',
            'nomor_transkrip.required' => 'Nomor Transkrip Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan:pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Transkrip'), $filenameSimpan);
    
                $upload = FileTranskrip::create([
                    'id_pegawai' => $request->id_pegawai,
                    //'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_trans_id' => $request->nama_file_trans_id,
                    'nomor_transkrip' => $request->nomor_transkrip,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Transkrip Berhasil Disimpan',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $trans_edit = FileTranskrip::where('id', $request->id)->first();
        if ($trans_edit) {
            return response()->json([
                'message' => 'Data Transkrip Ditemukan',
                'code' => 200,
                'data' => $trans_edit
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_trans_id' => 'required',
            'nomor_transkrip' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_trans_id.required' => 'Nama File Wajib diisi',
            'nomor_transkrip.required' => 'Nomor Transkrip Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan:pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileTranskrip::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/Transkrip/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/Transkrip'), $filenameSimpan);
    
                $upload = FileTranskrip::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_trans_id' => $request->nama_file_trans_id,
                    'nomor_transkrip' => $request->nomor_transkrip,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Transkrip Berhasil Disimpan',
                    'data' => $upload
                ]);
            }else {
                $upload = FileTranskrip::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nik_pegawai' => $request->nik_pegawai,
                    'nama_file_trans_id' => $request->nama_file_trans_id,
                    'nomor_transkrip' => $request->nomor_transkrip,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Transkrip Berhasil Diubah',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $transkrip = FileTranskrip::where('id', $request->id)->first();
        $delete = FileTranskrip::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Dokumen/Transkrip/'.$transkrip->file);
            return response()->json([
                'message' => 'Data Transkrip Berhasil Dihapus',
                'code' => 200,
            ]);
        }else {
            return response()->json([
                'message' => 'Gagal Hapus data, data Masih digunakan',
                'code' => 500,
            ]);
        }
    }
}
