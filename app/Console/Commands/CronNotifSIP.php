<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\FileTranskrip;
use App\Models\FileSTR;
use App\Models\FilSIP;
use App\Models\MasaBerlakuSIP;
use App\Models\MasterBerkas;
use App\Models\SetAplikasi;
use Validator;
use Mail;
use App\Mail\SendMailSIP;

class CronNotifSIP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifikasi:sip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifikasi SIP';

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
    
        $data = MasaBerlakuSIP::where('pengingat', $date_peringatan)
        ->where('status','active')
        ->join('file_sip','masa_berlaku_sip.sip_id','=','file_sip.id')
        ->join( "$database_2.pegawai as tbsik_pegawai",'file_sip.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_sip.nama_file_sip_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_sip.id_pegawai','tbsik_pegawai.nik','file_sip.no_sip','masa_berlaku_sip.tgl_ed','tbsik_pegawai.jbtn')
        ->get();
        $count = $data->count();

        // dd($count);
        if ($count > 0) {
            //Send Email
           Mail::to($data_aplikasi->email)
        //    ->cc(['wahyulazzuardy@gmail.com'])
           ->send(new SendMailSIP($data));
            //Update Status
            $update_status = MasaBerlakuSIP::where('pengingat', $date_peringatan)->where('status','active')
            ->update([
                'status' => 'proses'
            ]);

            \Log::info("[NOTIF EMAIL SIP], Email Berhasil dikirim.");
        }else {
            \Log::info("[NOTIF EMAIL SIP], Data Tidak ada");
        }
    }
}
