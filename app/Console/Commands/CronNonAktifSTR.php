<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileSTR;
use App\Models\MasterBerkas;
use App\Models\setAplikasi;
use Illuminate\Support\facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMail;

class CronNonAktifSTR extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nonaktif:str';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menonaktifkan STR';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $database_2 = config('database.connections.mysql2.database');
        $date_exp = Carbon::today()->toDateString();
    
        $data = FileSTR::where('tgl_ed', $date_exp)->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'proses');
        })
        ->join("$database_2.pegawai as tbsik_pegawai",'file_str.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_str.id_pegawai','tbsik_pegawai.nik','file_str.no_reg_str','file_str.kompetensi',
        'file_str.tgl_ed','tbsik_pegawai.jbtn')
        ->get();
        $count = $data->count();

        if ($count > 0) {
            $update_status = FileSTR::where('tgl_ed', $date_exp)->where(function($query){
                $query->where('status', 'active');
                $query->orWhere('status', 'proses');
            })->update([
                'status' => 'nonactive'
            ]);
            \Log::info("[NON-AKTIF STR], Berhasil Di Non-Aktifkan.");
        }else {
            \Log::info("[NON-AKTIF STR], Data Tidak Ada");
        }
    }
}
