<?php

namespace App\Http\Controllers;

use App\Models\FileVaksin;
use App\Models\FileKesehatan;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FileVaksinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getfile = FileVaksin::where('id_pegawai', $request->id)
        // ->join('master_berkas_pegawai', 'file_vaksin.nama_file_kesehatan_id', '=', 'master_berkas_pegawai.id')
        ->select('file_vaksin.id','file_vaksin.dosis','file_vaksin.jenis_vaksin',
        'file_vaksin.tempat_vaksin','file_vaksin.tgl_vaksin','file_vaksin.file')
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
            'id_pegawai' => 'required',
            // 'nama_file' => 'required',
            'dosis' => 'required',
            'jenis_vaksin' => 'required',
            'tgl_vaksin' => 'required',
            'tempat_vaksin' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            // 'nama_file.required' => 'Nama File Wajib Diisi',
            'dosis.required' => 'Dosis Vaksin Wajib Diisi',
            'jenis_vaksin.required' => 'Janis Vaksin Wajib Diisi',
            'tgl_vaksin.required' => 'Tanggal Vaksin Wajib Diisi',
            'tempat_vaksin.required' => 'Tempat Vaksin Wajib Diisi',
            'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Kesehatan/Vaksin/'), $filenameSimpan);
    
                $upload = FileVaksin::create([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nama_file_kesehatan_id' => $request->nama_file,
                    'dosis' => $request->dosis,
                    'jenis_vaksin' =>$request->jenis_vaksin,
                    'tgl_vaksin' => $request->tgl_vaksin,
                    'tempat_vaksin' =>$request->tempat_vaksin,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Vaksin ('.$request->jenis_vaksin.') Berhasil Disimpan',
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
     * @param  \App\Models\FileVaksin  $fileVaksin
     * @return \Illuminate\Http\Response
     */
    public function show(FileVaksin $fileVaksin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileVaksin  $fileVaksin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $dokumen = FileVaksin::where('id', $request->id)->first();
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
     * @param  \App\Models\FileVaksin  $fileVaksin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'id_pegawai' => 'required',
            // 'nama_file' => 'required',
            'dosis' => 'required',
            'jenis_vaksin' => 'required',
            'tgl_vaksin' => 'required',
            'tempat_vaksin' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'id_pegawai.required' => 'ID Pegawai Wajib diisi',
            // 'nama_file.required' => 'Nama File Wajib Diisi',
            'dosis.required' => 'Dosis Vaksin Wajib Diisi',
            'jenis_vaksin.required' => 'Janis Vaksin Wajib Diisi',
            'tgl_vaksin.required' => 'Tanggal Vaksin Wajib Diisi',
            'tempat_vaksin.required' => 'Tempat Vaksin Wajib Diisi',
            //'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileVaksin::where('id', $request->id)->first();
                File::delete('File/Pegawai/Kesehatan/Vaksin/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Kesehatan/Vaksin/'), $filenameSimpan);
    
                $upload = FileVaksin::where('id',$request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nama_file_kesehatan_id' => $request->nama_file,
                    'dosis' => $request->dosis,
                    'jenis_vaksin' =>$request->jenis_vaksin,
                    'tgl_vaksin' => $request->tgl_vaksin,
                    'tempat_vaksin' =>$request->tempat_vaksin,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Vaksin ('.$request->jenis_vaksin.') Berhasil Diubah',
                    'data' => $upload
                ]);
            }else {
                $upload = FileVaksin::where('id',$request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    // 'nama_file_kesehatan_id' => $request->nama_file,
                    'dosis' => $request->dosis,
                    'jenis_vaksin' =>$request->jenis_vaksin,
                    'tgl_vaksin' => $request->tgl_vaksin,
                    'tempat_vaksin' =>$request->tempat_vaksin,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas Vaksin ('.$request->jenis_vaksin.') Berhasil Diubah',
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
     * @param  \App\Models\FileVaksin  $fileVaksin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_file = FileVaksin::where('id', $request->id)->first();
        $delete = FileVaksin::where('id', $request->id)->delete();
        if ($delete) {
            File::delete('File/Pegawai/Kesehatan/Vaksin/'.$delete_file->file);
            return response()->json([
                'message' => 'Data Vaksin ('.$request->jenis.') Berhasil Dihapus',
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
