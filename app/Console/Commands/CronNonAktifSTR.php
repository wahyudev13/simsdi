<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\FileSTR;
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
        $hariPeringatan = 7; // jumlah hari sebelum tgl_ed
        $today = Carbon::today();
        $peringatanDate = $today->copy()->addDays($hariPeringatan);

        // 1. Update status menjadi 'akan_berakhir' jika tgl_ed = hariPeringatan ke depan
        $akanBerakhir = FileSTR::where('status', 'active')
            ->whereDate('tgl_ed', '>', $today)
            ->whereDate('tgl_ed', '<=', $today->copy()->addDays($hariPeringatan))
            ->update(['status' => 'akan_berakhir']);

        // 2. Kembalikan ke 'active' jika status 'akan_berakhir' tapi tgl_ed > hariPeringatan ke depan
        $backToActive = FileSTR::where('status', 'akan_berakhir')
            ->whereDate('tgl_ed', '>', $peringatanDate)
            ->update(['status' => 'active']);

        // 3. Update status menjadi 'nonactive' jika sudah lewat tgl_ed
        $nonactive = FileSTR::whereIn('status', ['active', 'akan_berakhir'])
            ->whereDate('tgl_ed', '<=', $today)
            ->update(['status' => 'nonactive']);

        $this->info("Status STR diupdate: $akanBerakhir akan_berakhir, $backToActive kembali active, $nonactive nonactive.");
        return Command::SUCCESS;
    }
}
