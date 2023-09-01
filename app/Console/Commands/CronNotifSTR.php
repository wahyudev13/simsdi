<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileSTR;
use App\Models\MasterBerkas;
use App\Models\SetAplikasi;
use Validator;
use Mail;
use App\Mail\sendMail;

class CronNotifSTR extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifikasi:str';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifikasi STR';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $database_2 = config('database.connections.mysql2.database');
        $data_aplikasi = SetAplikasi::first();
        $date_peringatan = Carbon::today()->toDateString();
    
        $data = FileSTR::where('pengingat', $date_peringatan)
        ->where('status','active')
        ->join( "$database_2.pegawai as tbsik_pegawai",'file_str.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_str.nama_file_str_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_str.id_pegawai','tbsik_pegawai.nik','file_str.no_reg_str','file_str.kompetensi',
        'file_str.tgl_ed','tbsik_pegawai.jbtn')
        ->get();
        $count = $data->count();

        // dd($count);
        if ($count > 0) {
            //Send Email
           Mail::to($data_aplikasi->email)
        //    ->cc(['wahyulazzuardy@gmail.com'])
           ->send(new sendMail($data));
            //Update Status
            $update_status = FileSTR::where('pengingat', $date_peringatan)->where('status','active')
            ->update([
                'status' => 'proses'
            ]);

            \Log::info("[NOTIF EMAIL STR], Email Berhasil dikirim.");
        }else {
            \Log::info("[NOTIF EMAIL STR], Data Tidak ada");
        }
    }
}
