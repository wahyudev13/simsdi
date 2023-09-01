<?php

namespace App\Console\Commands;
use App\Models\FileRiwayatKerja;
use App\Models\Pegawai;
use App\Models\FileIjazah;
use App\Models\MasterBerkas;
use App\Models\FileSTR;
use App\Models\setAplikasi;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CronNonAktifkontrak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nonaktif:kontrak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menonaktifkan Kontrak Kerja';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $database_2 = config('database.connections.mysql2.database');
        $date_exp = Carbon::today()->toDateString();
    
        $data = FileRiwayatKerja::where('tgl_ed', $date_exp)
        ->where(function($query){
            $query->where('status', 'active');
            $query->orWhere('status', 'proses');
        })
        ->join( "$database_2.pegawai as tbsik_pegawai",'file_riwayat_pekerjaan.id_pegawai','=','tbsik_pegawai.id')//join database simrs
        ->join('master_berkas_pegawai', 'file_riwayat_pekerjaan.nama_file_riwayat_id', '=', 'master_berkas_pegawai.id')
        ->select('tbsik_pegawai.nama','master_berkas_pegawai.nama_berkas','file_riwayat_pekerjaan.id_pegawai','tbsik_pegawai.nik',
        'file_riwayat_pekerjaan.nomor','file_riwayat_pekerjaan.tgl_ed','tbsik_pegawai.jbtn')
        ->get();
        $count = $data->count();

        if ($count > 0) {
            $update_status = FileRiwayatKerja::where('tgl_ed', $date_exp)->where(function($query){
                $query->where('status', 'active');
                $query->orWhere('status', 'proses');
            })->update([
                'status' => 'nonactive'
            ]);
            \Log::info("[NON-AKTIF KONTRAK KERJA], Berhasil Di Non-Aktifkan.");
        }else {
            \Log::info("[NON-AKTIF KONTRAK KERJA], Data Tidak Ada");
        }
    }
}
