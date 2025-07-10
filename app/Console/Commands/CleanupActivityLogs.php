<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class CleanupActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:cleanup {--days=30 : Number of days to keep logs} {--force : Force cleanup without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old activity logs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = $this->option('days');
        $force = $this->option('force');
        
        $cutoffDate = Carbon::now()->subDays($days);
        
        // Count logs to be deleted
        $count = Activity::where('created_at', '<', $cutoffDate)->count();
        
        if ($count === 0) {
            $this->info('No old activity logs found to clean up.');
            return 0;
        }
        
        if (!$force) {
            if (!$this->confirm("This will delete {$count} activity logs older than {$days} days. Are you sure?")) {
                $this->info('Cleanup cancelled.');
                return 0;
            }
        }
        
        // Delete old logs
        $deleted = Activity::where('created_at', '<', $cutoffDate)->delete();
        
        $this->info("Successfully deleted {$deleted} activity logs older than {$days} days.");
        
        // Log the cleanup activity
        activity()
            ->withProperties([
                'deleted_count' => $deleted,
                'cutoff_date' => $cutoffDate->toISOString(),
                'command_executed_at' => now()->toISOString()
            ])
            ->log('Activity log cleanup executed');
        
        return 0;
    }
} 