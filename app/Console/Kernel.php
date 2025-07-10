<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\setAplikasi;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       
        $schedule->command('notifikasi:sip')->everyMinute();
        $schedule->command('notifikasi:str')->everyMinute();
        $schedule->command('nonaktif:str')->everyMinute();
        $schedule->command('notifikasi:kontrak')->everyMinute();
        $schedule->command('nonaktif:kontrak')->everyMinute();
        
        // Cleanup activity logs every week
        $schedule->command('activity:cleanup --days=90 --force')->weekly();
    

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
