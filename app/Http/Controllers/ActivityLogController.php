<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Handle AJAX stats request
        if ($request->has('ajax') && $request->ajax === 'stats') {
            return $this->getStats();
        }

        // Get current user for logging (support both web and admin guard)
        $currentUser = Auth::user() ?? Auth::guard('admin')->user();

        $query = Activity::with('causer')->orderBy('created_at', 'desc');

        // Filter by log name
        if ($request->has('log_name') && $request->log_name) {
            $query->where('log_name', $request->log_name);
        }

        // Filter by event
        if ($request->has('event') && $request->event) {
            if ($request->event === 'failed') {
                $query->where('description', 'like', '%Failed%login%');
            } else {
                $query->where('event', $request->event);
            }
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('causer_id', $request->user_id);
        }

        $activities = $query->paginate(20);

        // Get unique log names for filter
        $logNames = Activity::distinct()->pluck('log_name');
        
        // Get unique events for filter
        $events = Activity::distinct()->pluck('event');

        // Debug information
        \Log::info('Activity Log Debug', [
            'total_activities' => $activities->total(),
            'current_page' => $activities->currentPage(),
            'per_page' => $activities->perPage(),
            'log_names' => $logNames->toArray(),
            'events' => $events->toArray(),
            'user' => $currentUser ? $currentUser->username : 'No user'
        ]);

        return view('pages.Setting.activity-log', compact('activities', 'logNames', 'events'));
    }

    /**
     * Get activity log statistics
     */
    private function getStats()
    {
        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();

        $stats = [
            'today_activities' => Activity::whereDate('created_at', $today->toDateString())->count(),
            'recent_activities' => Activity::where('created_at', '>=', $yesterday)->count(),
            'failed_logins' => Activity::where('description', 'like', '%Failed%login%')
                ->where('created_at', '>=', $yesterday)->count(),
            'user_activities' => Activity::where('log_name', 'user')
                ->whereDate('created_at', $today->toDateString())->count(),
            'admin_activities' => Activity::where('log_name', 'admin')
                ->whereDate('created_at', $today->toDateString())->count(),
            'file_ijazah_activities' => Activity::where('log_name', 'file_ijazah')
                ->whereDate('created_at', $today->toDateString())->count(),
            'file_ijazah_uploads' => Activity::where('log_name', 'file_ijazah')
                ->where('description', 'like', '%menambahkan%')
                ->whereDate('created_at', $today->toDateString())->count(),
            'file_ijazah_updates' => Activity::where('log_name', 'file_ijazah')
                ->where('description', 'like', '%mengubah%')
                ->whereDate('created_at', $today->toDateString())->count(),
            'file_ijazah_deletes' => Activity::where('log_name', 'file_ijazah')
                ->where('description', 'like', '%menghapus%')
                ->whereDate('created_at', $today->toDateString())->count(),
            'verifikasi_ijazah_activities' => Activity::where('log_name', 'verifikasi_ijazah')
                ->whereDate('created_at', $today->toDateString())->count(),
            'verifikasi_ijazah_uploads' => Activity::where('log_name', 'verifikasi_ijazah')
                ->where('description', 'like', '%menambahkan%')
                ->whereDate('created_at', $today->toDateString())->count(),
            'verifikasi_ijazah_deletes' => Activity::where('log_name', 'verifikasi_ijazah')
                ->where('description', 'like', '%menghapus%')
                ->whereDate('created_at', $today->toDateString())->count(),
        ];

        return response()->json($stats);
    }

    public function show($id)
    {
        $activity = Activity::with('causer')->findOrFail($id);
        
        return view('pages.Setting.activity-log-detail', compact('activity'));
    }

    public function clearLogs(Request $request)
    {
        // Clear logs older than specified days
        $days = $request->input('days', 30);
        
        $deletedCount = Activity::where('created_at', '<', now()->subDays($days))->delete();
        
        return response()->json([
            'status' => 200,
            'message' => "Berhasil menghapus {$deletedCount} log aktivitas yang lebih dari {$days} hari",
            'deleted_count' => $deletedCount
        ]);
    }

    public function exportLogs(Request $request)
    {
        $query = Activity::with('causer')->orderBy('created_at', 'desc');

        // Apply same filters as index method
        if ($request->has('log_name') && $request->log_name) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->has('event') && $request->event) {
            if ($request->event === 'failed') {
                $query->where('description', 'like', '%Failed%login%');
            } else {
                $query->where('event', $request->event);
            }
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('causer_id', $request->user_id);
        }

        $activities = $query->get();

        $filename = 'activity_logs_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($activities) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Log Name', 'Description', 'Event', 'Username', 'Name', 'NIK',
                'Failed Login Username', 'Failed Login Password', 'IP Address', 'User Agent', 'Created At'
            ]);

            foreach ($activities as $activity) {
                $properties = $activity->properties;
                
                fputcsv($file, [
                    $activity->id,
                    $activity->log_name,
                    $activity->description,
                    $activity->event,
                    $activity->causer ? $activity->causer->username : 'System',
                    $properties['user_name'] ?? '-',
                    $properties['employee_nik'] ?? '-',
                    $properties['attempted_username'] ?? '-',
                    $properties['attempted_password'] ?? '-',
                    $properties['ip_address'] ?? '-',
                    $properties['user_agent'] ?? '-',
                    $activity->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 