<?php

namespace App\Http\Controllers;

use App\Models\FileSertifPelatihan;
use App\Models\MasterBerkas;
use App\Models\Pegawai;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Illuminate\Http\Request;

class FileSertifPelatihanController extends Controller
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

    public function get(Request $request) {

        $get = FileSertifPelatihan::where('id_pegawai', $request->id)
        ->join('master_berkas_pegawai', 'sertif_pelatihan.berkas_id', '=', 'master_berkas_pegawai.id')
        ->select('sertif_pelatihan.id','sertif_pelatihan.berkas_id','sertif_pelatihan.id_pegawai','sertif_pelatihan.nm_kegiatan','sertif_pelatihan.tgl_kegiatan',
        'sertif_pelatihan.tmp_kegiatan','sertif_pelatihan.penyelenggara','sertif_pelatihan.file','master_berkas_pegawai.nama_berkas')
        ->get();

        return DataTables::of($get)
        ->addIndexColumn()
        ->make(true);
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
            // 'id_pegawai' => 'required',
            'berkas_id' => 'required',
            'nm_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'tmp_kegiatan' => 'required',
            'penye_kegiatan' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            // 'id_pegawai.required' => 'Nama File Wajib diisi',
            'berkas_id.required' => 'Jenis Sertifikat Pelatihan Wajib Dipilih',
            'nm_kegiatan.required' => 'Nama Kegiatan / Pelatihan Wajib diisi',
            'tgl_kegiatan.required' => 'Tanggal Kegiatan / Pelatihan Wajib diisi',
            'tmp_kegiatan.required' => 'Tempat Kegiatan / Pelatihan Wajib diisi',
            'penye_kegiatan.required' => 'Penyelenggara Kegiatan / Pelatihan Wajib diisi',
            'file.required' => 'File Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Diklat/Sertifikat-Pelatihan'), $filenameSimpan);
    
                $store = FileSertifPelatihan::create([
                    'id_pegawai' => $request->id_pegawai,
                    'berkas_id' => $request->berkas_id,
                    'nm_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan,
                    'tmp_kegiatan' => $request->tmp_kegiatan,
                    'penyelenggara' => $request->penye_kegiatan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$request->nm_kegiatan.' '.$pegawai->nama.' Berhasil Disimpan',
                    'data' => $store
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
     * @param  \App\Models\FileSertifPelatihan  $fileSertifPelatihan
     * @return \Illuminate\Http\Response
     */
    public function show(FileSertifPelatihan $fileSertifPelatihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileSertifPelatihan  $fileSertifPelatihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $dokumen = FileSertifPelatihan::where('id', $request->id)->first();
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
     * @param  \App\Models\FileSertifPelatihan  $fileSertifPelatihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            // 'id_pegawai' => 'required',
            'berkas_id' => 'required',
            'nm_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'tmp_kegiatan' => 'required',
            'penye_kegiatan' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            // 'id_pegawai.required' => 'Nama File Wajib diisi',
            'berkas_id.required' => 'Jenis Sertifikat Pelatihan Wajib Dipilih',
            'nm_kegiatan.required' => 'Nama Kegiatan / Pelatihan Wajib diisi',
            'tgl_kegiatan.required' => 'Tanggal Kegiatan / Pelatihan Wajib diisi',
            'tmp_kegiatan.required' => 'Tempat Kegiatan / Pelatihan Wajib diisi',
            'penye_kegiatan.required' => 'Penyelenggara Kegiatan / Pelatihan Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {

                $delete_file = FileSertifPelatihan::where('id', $request->id)->first();
                File::delete('File/Pegawai/Diklat/Sertifikat-Pelatihan/'.$delete_file->file);

                $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                $request->file('file')->move(public_path('File/Pegawai/Diklat/Sertifikat-Pelatihan'), $filenameSimpan);
    
                $update = FileSertifPelatihan::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'berkas_id' => $request->berkas_id,
                    'nm_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan,
                    'tmp_kegiatan' => $request->tmp_kegiatan,
                    'penyelenggara' => $request->penye_kegiatan,
                    'file' => $filenameSimpan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$pegawai->nama.' Berhasil Diupdate',
                    'data' => $update
                ]);
            }else {

                $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
                $pegawai = Pegawai::where('id', $request->id_pegawai)->first();

                $update = FileSertifPelatihan::where('id', $request->id)->update([
                    'id_pegawai' => $request->id_pegawai,
                    'berkas_id' => $request->berkas_id,
                    'nm_kegiatan' => $request->nm_kegiatan,
                    'tgl_kegiatan' => $request->tgl_kegiatan,
                    'tmp_kegiatan' => $request->tmp_kegiatan,
                    'penyelenggara' => $request->penye_kegiatan
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$pegawai->nama.' Berhasil Diupdate',
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
     * @param  \App\Models\FileSertifPelatihan  $fileSertifPelatihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dokumen = FileSertifPelatihan::where('id', $request->id)->first();
        $delete_file = FileSertifPelatihan::where('id', $request->id)->delete();

        $master_berkas_kompetensi = MasterBerkas::where('id',$request->berkas_id)->first();
        $pegawai = Pegawai::where('id', $request->id_pegawai)->first();
        
        if ($delete_file) {
            File::delete('File/Pegawai/Diklat/Sertifikat-Pelatihan/'.$dokumen->file);
            return response()->json([
                'message' => 'Berkas '.$master_berkas_kompetensi->nama_berkas.' '.$pegawai->nama.' Berhasil Dihapus',
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
