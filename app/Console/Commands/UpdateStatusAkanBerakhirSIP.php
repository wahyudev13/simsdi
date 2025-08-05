<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MasaBerlakuSIP;
use Carbon\Carbon;

class UpdateStatusAkanBerakhirSIP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sip:update-akan-berakhir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status SIP menjadi akan_berakhir jika mendekati tgl_ed, dan nonactive jika sudah lewat tgl_ed';

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
        $akanBerakhir = MasaBerlakuSIP::where('status', 'active')
            ->whereDate('tgl_ed', '>', $today)
            ->whereDate('tgl_ed', '<=', $today->copy()->addDays($hariPeringatan))
            ->update(['status' => 'akan_berakhir']);

        // 2. Kembalikan ke 'active' jika status 'akan_berakhir' tapi tgl_ed > hariPeringatan ke depan
        $backToActive = MasaBerlakuSIP::where('status', 'akan_berakhir')
            ->whereDate('tgl_ed', '>', $peringatanDate)
            ->update(['status' => 'active']);

        // 3. Update status menjadi 'nonactive' jika sudah lewat tgl_ed
        $nonactive = MasaBerlakuSIP::whereIn('status', ['active', 'akan_berakhir'])
            ->whereDate('tgl_ed', '<=', $today)
            ->update(['status' => 'nonactive']);

        $this->info("Status SIP diupdate: $akanBerakhir akan_berakhir, $backToActive kembali active, $nonactive nonactive.");
        return Command::SUCCESS;
    }
}
