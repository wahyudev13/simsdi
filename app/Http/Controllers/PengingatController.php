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
use App\Models\MasaBerlakuSIP;
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

        $getstr = FileSTR::where('status','nonactive')->orWhere('status','akan_berakhir')
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
        $getkontrak = FileRiwayatKerja::where('status','nonactive')->orWhere('status','akan_berakhir')
        ->join( "$database_2.pegawai as tbsik_pegawai",'file_riwayat_pekerjaan.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_riwayat_pekerjaan.nama_file_riwayat_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_riwayat_pekerjaan.id_pegawai','tbsik_pegawai.nik',
        'file_riwayat_pekerjaan.nomor','file_riwayat_pekerjaan.tgl_ed','tbsik_pegawai.jbtn','file_riwayat_pekerjaan.status')
        ->get();

        return DataTables::of($getkontrak)
        ->addIndexColumn()
        ->make(true);
    }

    public function pengingatSip(){
        return view('pages.Pengingat.pengingat-sip');
    }

    public function getSip(){
        $database_2 = config('database.connections.mysql2.database');
        $data = MasaBerlakuSIP::where('status','nonactive')->orWhere('status','akan_berakhir')
        ->join('file_sip','masa_berlaku_sip.sip_id','=','file_sip.id')
        ->join( "$database_2.pegawai as tbsik_pegawai",'file_sip.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_sip.nama_file_sip_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_sip.id_pegawai','tbsik_pegawai.nik','file_sip.no_sip','masa_berlaku_sip.tgl_ed','masa_berlaku_sip.status','tbsik_pegawai.jbtn')
        ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }


}
