<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileRiwayatKerja;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileSTR;
use App\Models\FileSIP;
use App\Models\MasterBerkas;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;

class PengingatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $database_2 = config('database.connections.mysql2.database');

        // $getstr = FileSTR::where('status','nonactive')->orWhere('status','proses')
        // ->join("$database_2.pegawai as tbsik_pegawai",'file_str.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        // ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        // ->select('tbsik_pegawai.nama','tbsik_pegawai.nik','tbsik_pegawai.jbtn','master_berkas_pegawai.nama_berkas','file_str.id_pegawai',
        // 'file_str.no_reg_str','file_str.kompetensi','file_str.tgl_ed','file_str.status')
        // ->get();

        // $countstr = $getstr->count();
        // $data =[
        //     'countstr' => $countstr
        // ];
       return view('pages.Pengingat.pengingat-str');
    }

    public function get() {
        $database_2 = config('database.connections.mysql2.database');

        $getstr = FileSTR::where('status','nonactive')->orWhere('status','proses')
        ->join("$database_2.pegawai as tbsik_pegawai",'file_str.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.id AS id_pegawai','tbsik_pegawai.nama','tbsik_pegawai.nik','tbsik_pegawai.jbtn','master_berkas_pegawai.nama_berkas','file_str.id_pegawai',
        'file_str.no_reg_str','file_str.kompetensi','file_str.tgl_ed','file_str.status','file_str.id')
        ->get();

        return DataTables::of($getstr)
        ->addIndexColumn()
        ->make(true);
    }

    // public function getcount() {
    //     $database_2 = config('database.connections.mysql2.database');

    //     $getstr = FileSTR::where('status','nonactive')->orWhere('status','proses')
    //     ->join("$database_2.pegawai as tbsik_pegawai",'file_str.id_pegawai','=','tbsik_pegawai.id')//join database simrs
    //     ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
    //     ->select('tbsik_pegawai.nama','tbsik_pegawai.nik','tbsik_pegawai.jbtn','master_berkas_pegawai.nama_berkas','file_str.id_pegawai',
    //     'file_str.no_reg_str','file_str.kompetensi','file_str.tgl_ed','file_str.status')
    //     ->get();

    //     $countstr = $getstr->count();

    //     $data =[
    //         'countstr' => $countstr
    //     ];

    //     return view('partial.sidebar',$data);

    // }

    public function pengingatKontrak() {
        return view('pages.Pengingat.pengingat-kontrak');
    }

    public function getkontrak() {
        $database_2 = config('database.connections.mysql2.database');
        $getkontrak = FileRiwayatKerja::where('status','nonactive')->orWhere('status','proses')
        ->join( "$database_2.pegawai as tbsik_pegawai",'file_riwayat_pekerjaan.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_riwayat_pekerjaan.nama_file_riwayat_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_riwayat_pekerjaan.id_pegawai','tbsik_pegawai.nik',
        'file_riwayat_pekerjaan.nomor','file_riwayat_pekerjaan.tgl_ed','tbsik_pegawai.jbtn','file_riwayat_pekerjaan.status')
        ->get();

        return DataTables::of($getkontrak)
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
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
