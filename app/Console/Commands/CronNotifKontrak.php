<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FileRiwayatKerja;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use App\Models\SetAplikasi;
use File;
use Carbon\Carbon;
use App\Mail\emailKontrak;
use Illuminate\Support\Facades\Mail;

class CronNotifKontrak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifikasi:kontrak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifikasi Email Masa Kontrak Kerja';

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
    
        $data = FileRiwayatKerja::where('pengingat', $date_peringatan)
        ->where('status','active')
        ->join( "$database_2.pegawai as tbsik_pegawai",'file_riwayat_pekerjaan.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_riwayat_pekerjaan.nama_file_riwayat_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_riwayat_pekerjaan.id_pegawai','tbsik_pegawai.nik',
        'file_riwayat_pekerjaan.nomor','file_riwayat_pekerjaan.tgl_ed','tbsik_pegawai.jbtn')
        ->get();
        $count = $data->count();

        // dd($count);
        if ($count > 0) {
            //Send Email
           Mail::to($data_aplikasi->email)
        //    ->cc(['wahyulazzuardy@gmail.com'])
           ->send(new emailKontrak($data));
            //Update Status
            $update_status = FileRiwayatKerja::where('pengingat', $date_peringatan)->where('status','active')
            ->update([
                'status' => 'proses'
            ]);

            \Log::info("[NOTIF EMAIL KONTRAK KERJA], Email Berhasil dikirim.");
        }else {
            \Log::info("[NOTIF EMAIL KONTRAK KERJA], Data Tidak ada");
        }
    }
}
