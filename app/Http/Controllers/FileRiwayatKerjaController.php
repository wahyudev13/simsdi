<?php

namespace App\Http\Controllers;

use App\Models\FileRiwayatKerja;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use App\Models\setAplikasi;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;
use App\Mail\emailKontrak;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class FileRiwayatKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('email.email-kontrak');
    }
    public function getRiwayat(Request $request)
    {
        $get_riwayat_kerja = FileRiwayatKerja::where('file_riwayat_pekerjaan.id_pegawai', $request->id)
        ->join('master_berkas_pegawai', 'file_riwayat_pekerjaan.nama_file_riwayat_id', '=', 'master_berkas_pegawai.id')
        ->select('file_riwayat_pekerjaan.id','file_riwayat_pekerjaan.id_pegawai','file_riwayat_pekerjaan.nomor','file_riwayat_pekerjaan.file','master_berkas_pegawai.nama_berkas',
        'file_riwayat_pekerjaan.tgl_ed','file_riwayat_pekerjaan.pengingat','file_riwayat_pekerjaan.updated_at','file_riwayat_pekerjaan.status',
        )
        ->orderBy('file_riwayat_pekerjaan.created_at','desc')
        ->get();

        return DataTables::of($get_riwayat_kerja)
        ->editColumn('updated_at',function($get_riwayat_kerja) {
            return $get_riwayat_kerja->updated_at->format('j F Y h:i:s A');
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
            'nama_file_riwayat_id' => 'required',
            'nomor' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ],[
            'nama_file_riwayat_id.required' => 'Nama File Wajib diisi',
            'nomor.required' => 'Nomor Wajib diisi',
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
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/RiwayatKerja'), $filenameSimpan);

                $date = Carbon::today()->toDateString();

                if ($request->tgl_ed != $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::create([
                        'id_pegawai' => $request->id_pegawai,
                        // 'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'active',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed != $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::create([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'proses',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::create([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::create([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }
                return response()->json([
                    'status' => 200,
                    'message' => 'Dokumen Riwayat Pekerjaan Berhasil Disimpan',
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
     * @param  \App\Models\FileRiwayatKerja  $fileRiwayatKerja
     * @return \Illuminate\Http\Response
     */
    public function show(FileRiwayatKerja $fileRiwayatKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileRiwayatKerja  $fileRiwayatKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $riwayat = FileRiwayatKerja::where('id', $request->id)->first();
        if ($riwayat) {
            return response()->json([
                'message' => 'Data Riwayat Pekerjaan Ditemukan',
                'code' => 200,
                'data' => $riwayat
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
     * @param  \App\Models\FileRiwayatKerja  $fileRiwayatKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'nama_file_riwayat_id' => 'required',
            'nomor' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ],[
            'nama_file_riwayat_id.required' => 'Nama File Wajib diisi',
            'nomor.required' => 'Nomor Wajib diisi',
            'file.mimes' => 'Format File yang diizinkan: pdf',
            'file.max' => 'File Maksimal 2MB'
        ]);

        if ($validated->passes()) {
            if ($request->hasFile('file')) {
                
                $delete_file = FileRiwayatKerja::where('id', $request->id)->first();
                File::delete('File/Pegawai/Dokumen/RiwayatKerja/'.$delete_file->file);

                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenameSimpan = $filename.'_'.time().'.'.$extension;
                // $filename = time().'.'.$request->file('berkas')->extension();
                $request->file('file')->move(public_path('File/Pegawai/Dokumen/RiwayatKerja'), $filenameSimpan);

                $date = Carbon::today()->toDateString();

                if ($request->tgl_ed != $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'active',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed != $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'proses',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                        'file' => $filenameSimpan
                    ]);
                }
            }else {
                $date = Carbon::today()->toDateString();
                if ($request->tgl_ed != $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'active',
                       
                    ]);
                }elseif ($request->tgl_ed != $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'proses',
                       
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat != $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                       
                    ]);
                }elseif ($request->tgl_ed == $date && $request->pengingat == $date) {
                    $upload = FileRiwayatKerja::where('id',$request->id)->update([
                        'id_pegawai' => $request->id_pegawai,
                      //'nik_pegawai' => $request->nik_pegawai,
                        'nama_file_riwayat_id' => $request->nama_file_riwayat_id,
                        'nomor' => $request->nomor,
                        'tgl_ed' => $request->tgl_ed,
                        'pengingat' => $request->pengingat,
                        'status' => 'nonactive',
                       
                    ]);
                }
            }
            return response()->json([
                'status' => 200,
                'message' => 'Dokumen Riwayat Pekerjaan Berhasil Diubah',
                'data' => $upload
            ]);

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
     * @param  \App\Models\FileRiwayatKerja  $fileRiwayatKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_riwayat = FileRiwayatKerja::where('id', $request->id)->first();
            $delete = FileRiwayatKerja::where('id', $request->id)->delete();
            if ($delete) {
                File::delete('File/Pegawai/Dokumen/RiwayatKerja/'.$delete_riwayat->file);
                return response()->json([
                    'message' => 'Data Riwayat Kerja Berhasil Dihapus',
                    'code' => 200,
                ]);
            }
    }

    public function updatestatus(Request $request) {
        $upload = FileRiwayatKerja::where('id', $request->id)->update([
            'status' => $request->status
        ]);
        if ($upload) {
            return response()->json([
                'status' => 200,
                'message' => 'Status Dokumen '.$request->naber.' Berhasil Diubah',
                'data' => $upload
            ]);
        }

        
    }
}
