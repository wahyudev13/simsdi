<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Departemen;
use App\Models\FileRiwayatKerja;
use App\Models\Devisi;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileSTR;
use App\Models\FileSIP;
use App\Models\MasterBerkas;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class Karyawan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {
        $auth = Auth::user()->id_pegawai;
        $pegawai = Pegawai::where('id', $auth)->first();

        $deparetemen = Departemen::get();

        $alert_pengingat = FileSTR::where('status','proses')->count();
        $alert_exp = FileSTR::where('status','nonactive')->count();
        $peringatan_kontrak_kerja = FileRiwayatKerja::where('status','proses')->count();
        $peringatan_nonaktif_kontrak_kerja = FileRiwayatKerja::where('status','nonactive')->count();

        $data = [
            'alert_pengingat' => $alert_pengingat,
            'alert_exp' => $alert_exp,
            'peringatan_kontrak_kerja' => $peringatan_kontrak_kerja,
            'peringatan_nonaktif_kontrak_kerja' => $peringatan_nonaktif_kontrak_kerja,
            'deparetemen' => $deparetemen,
            'pegawai' => $pegawai
        ];
        return view('pages.Karyawan.pegawai', $data);
    }
    //->join('sik_new.pegawai as tbsik_pegawai','file_str.id_pegawai','=','tbsik_pegawai.id')//join database simrs
    public function getPegawai()
    {
        $database_1 =  env('DB_DATABASE');
        $pegawai = Pegawai::whereNotIn('pegawai.stts_aktif',['keluar'])->join('departemen','pegawai.departemen','=','departemen.dep_id')
        //->leftjoin("$database_1.file_riwayat_pekerjaan as riwayat",'pegawai.id','=','riwayat.id_pegawai')
        //->leftJoin("$database_1.master_berkas_pegawai as master_berkas_kontrak", 'riwayat.nama_file_riwayat_id', '=', 'master_berkas_kontrak.id')
        ->select('pegawai.id','pegawai.nik','pegawai.nama','pegawai.jk','pegawai.jbtn','departemen.nama AS nama_dep')
        ->orderBy('departemen.nama','asc')
        ->get();

        return DataTables::of($pegawai)
        ->addIndexColumn()
        ->make(true);
        // $pegawai = Pegawai::join('departemen','pegawai.departemen','=','departemen.dep_id')
        // ->leftJoin("$database_1.file_str as tbstr",'pegawai.id','=','tbstr.id_pegawai')
        // ->leftJoin("$database_1.master_berkas_pegawai as master_berkas", 'tbstr.nama_file_str_id', '=', 'master_berkas.id')
        // ->leftjoin("$database_1.file_riwayat_pekerjaan as riwayat",'pegawai.id','=','riwayat.id_pegawai')
        // ->leftJoin("$database_1.master_berkas_pegawai as master_berkas_kontrak", 'riwayat.nama_file_riwayat_id', '=', 'master_berkas_kontrak.id')
        // ->select('pegawai.id','pegawai.nik','pegawai.nama','pegawai.jk','pegawai.jbtn','departemen.nama AS nama_dep','tbstr.file',
        // 'master_berkas.nama_berkas','tbstr.status','master_berkas_kontrak.nama_berkas AS nama_berkas_kontrak','riwayat.status as status_kontrak')
        // ->get();
        // return DataTables::of($pegawai)
        // ->addIndexColumn()
        // ->make(true);
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
