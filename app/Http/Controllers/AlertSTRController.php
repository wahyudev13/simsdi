<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileSTR;
use App\Models\MasterBerkas;
use Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMail;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class AlertSTRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $date_peringatan = Carbon::today()->toDateString();
    
        // $data = FileSTR::where('pengingat', $date_peringatan)
        // ->join('sik_new.pegawai as tbsik_pegawai','file_str.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        // ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        // ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_str.id_pegawai','file_str.nik_pegawai','file_str.no_reg_str','file_str.kompetensi')
        // ->get();
        // $count = $data->count();

        // // dd($count);
        // if ($count > 0) {
        //    Mail::to('skahaart@gmail.com')
        // //    ->cc(['wahyulazzuardy@gmail.com'])
        //    ->send(new sendMail($data));
        //    var_dump("Email Berhasil dikirim.");
        // }else {
        //     var_dump("Data Tidak ada");
        // }
        // return view('email.content');

        // $oMerger = PDFMerger::init();

        // $oMerger->addPDF(public_path('Pegawai\Dokumen\Ijazah\1031 Surat Implementasi Janji Layanan JKN FKRTL_Revisi DS_1685973919.pdf'),'all');
        // $oMerger->addPDF(public_path('Pegawai/Dokumen/Transkrip/0854c036c892092d8394a837fcb6ed70_1685949376.pdf'), 'all');

        // $oMerger->merge();
        // $oMerger->stream();

        $date_exp = Carbon::today()->toDateString();
    
        $data = FileSTR::where('tgl_ed', $date_exp)->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'proses');
        })
        ->join('sik_new.pegawai as tbsik_pegawai','file_str.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_str.id_pegawai','file_str.nik_pegawai','file_str.no_reg_str','file_str.kompetensi',
        'file_str.tgl_ed','tbsik_pegawai.jbtn')
        ->get();
        $count = $data->count();

        dd($count);
       
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
