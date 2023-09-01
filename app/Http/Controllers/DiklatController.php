<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PenilaianKerja;
use App\Models\FileKesehatan;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use App\Models\AbsenDiklat;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use File;
use Carbon\Carbon;

class DiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $pegawai = Pegawai::where('id', $id)->join('departemen','pegawai.departemen','=','departemen.dep_id')
        ->select('pegawai.id','pegawai.nama','pegawai.jbtn','pegawai.nik','departemen.nama AS nama_dep')
        ->first();
        $master_berkas_kompetensi = MasterBerkas::where('kategori','kompetensi')->get();
        $data = [
            'pegawai' => $pegawai,
            'master_berkas_kompetensi' => $master_berkas_kompetensi
        ];
        return view('pages.Karyawan.berkas-diklat',$data);
    }

    public function absen_iht(Request $request) {
       
        $database_2 = config('database.connections.mysql2.database');
        if (!empty($request->from_date)) {
            $get = AbsenDiklat::where('id_pegawai',$request->id)->whereBetween('absensi_diklat.masuk_at', [$request->from_date, $request->to_date])
            ->join("$database_2.pegawai as pegawai",'absensi_diklat.id_pegawai','=','pegawai.id')//join database simrs
            ->join("$database_2.departemen as departemen",'pegawai.departemen','=','departemen.dep_id')
            ->join('kegiatan','absensi_diklat.kegiatan_id','=','kegiatan.id')
            ->select('absensi_diklat.id','pegawai.id AS id_pegawai','pegawai.nik','pegawai.nama AS nama_pegawai','kegiatan.nama AS nama_kegiatan','departemen.nama AS nama_dep',
            'absensi_diklat.masuk_at','absensi_diklat.selesai_at','absensi_diklat.total_waktu','kegiatan.tempat','absensi_diklat.poin')
            ->get();
        }else {
            $get = AbsenDiklat::where('id_pegawai',$request->id)
            ->join("$database_2.pegawai as pegawai",'absensi_diklat.id_pegawai','=','pegawai.id')//join database simrs
            ->join("$database_2.departemen as departemen",'pegawai.departemen','=','departemen.dep_id')
            ->join('kegiatan','absensi_diklat.kegiatan_id','=','kegiatan.id')
            ->select('absensi_diklat.id','pegawai.id AS id_pegawai','pegawai.nik','pegawai.nama AS nama_pegawai','kegiatan.nama AS nama_kegiatan','departemen.nama AS nama_dep',
            'absensi_diklat.masuk_at','absensi_diklat.selesai_at','absensi_diklat.total_waktu','kegiatan.tempat','absensi_diklat.poin')
            ->get();
        }

        return DataTables::of($get)
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
