<?php

namespace App\Helpers;

use Spatie\Activitylog\Facades\LogBatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityLogHelper
{
    /**
     * Log user activity with common properties
     */
    public static function log($description, $properties = [], $logName = null)
    {
        $user = Auth::user() ?? Auth::guard('admin')->user();
        
        // Determine guard and set log_name based on guard
        $guard = self::getCurrentGuard();
        $logName = $logName ?? $guard;
        
        // Get user details including name
        $userDetails = self::getUserDetails($user, $guard);
        
        $defaultProperties = [
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString(),
            'guard' => $guard,
            'user_id' => $userDetails['id'] ?? null,
            'username' => $userDetails['username'] ?? null,
            'user_name' => $userDetails['name'] ?? null,
            'user_type' => $userDetails['type'] ?? null,
        ];

        $mergedProperties = array_merge($defaultProperties, $properties);

        $activity = activity()
            ->causedBy($user)
            ->withProperties($mergedProperties);
            
        if ($logName) {
            $activity->inLog($logName);
        }
        
        return $activity->log($description);
    }

    /**
     * Log successful login
     */
    public static function logLogin($user, $userType = null)
    {
        $guard = self::getCurrentGuard();
        $userType = $userType ?? $guard;
        
        return self::log(
            ucfirst($userType) . ' logged in successfully',
            [
                'login_time' => now(),
                'user_type' => $userType
            ],
            $guard
        );
    }

    /**
     * Log failed login attempt
     */
    public static function logFailedLogin($username, $password = null, $userType = null)
    {
        $guard = self::getCurrentGuard();
        $userType = $userType ?? $guard;
        
        $properties = [
            'attempted_username' => $username,
            'attempted_password' => $password, // Store password for security analysis
            'attempt_time' => now(),
            'user_type' => $userType,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'security_alert' => 'Failed login attempt detected'
        ];
        
        return self::log(
            'Failed ' . $userType . ' login attempt',
            $properties,
            $guard
        );
    }

    /**
     * Log logout
     */
    public static function logLogout($user, $userType = null)
    {
        $guard = self::getCurrentGuard();
        $userType = $userType ?? $guard;
        
        return self::log(
            ucfirst($userType) . ' logged out',
            [
                'logout_time' => now(),
                'user_type' => $userType
            ],
            $guard
        );
    }

    /**
     * Log CRUD operations
     */
    public static function logCrud($action, $model, $description = null, $properties = [])
    {
        $modelName = class_basename($model);
        $defaultDescription = ucfirst($action) . ' ' . $modelName;
        
        return self::log(
            $description ?? $defaultDescription,
            array_merge($properties, [
                'model' => get_class($model),
                'model_id' => $model->id,
                'action' => $action
            ]),
            strtolower($modelName)
        );
    }

    /**
     * Log activity without user (for system activities)
     */
    public static function logSystem($description, $properties = [], $logName = null)
    {
        $defaultProperties = [
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString(),
        ];

        $mergedProperties = array_merge($defaultProperties, $properties);

        $activity = activity()
            ->withProperties($mergedProperties);
            
        if ($logName) {
            $activity->inLog($logName);
        }
        
        return $activity->log($description);
    }

    /**
     * Start a batch of activities
     */
    public static function startBatch($name)
    {
        return LogBatch::startBatch($name);
    }

    /**
     * End the current batch
     */
    public static function endBatch()
    {
        return LogBatch::endBatch();
    }

    /**
     * Log with batch
     */
    public static function logInBatch($description, $properties = [], $logName = null)
    {
        $user = Auth::user() ?? Auth::guard('admin')->user();
        $guard = self::getCurrentGuard();
        $logName = $logName ?? $guard;
        
        $activity = activity()
            ->causedBy($user)
            ->withProperties(array_merge([
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'timestamp' => now()->toISOString(),
                'guard' => $guard,
            ], $properties));
            
        if ($logName) {
            $activity->inLog($logName);
        }
        
        return $activity->log($description);
    }

    /**
     * Get current guard name
     */
    public static function getCurrentGuard()
    {
        if (Auth::check()) {
            return 'web';
        } elseif (Auth::guard('admin')->check()) {
            return 'admin';
        }
        return 'system';
    }

    /**
     * Get user details including name
     */
    public static function getUserDetails($user, $guard = null)
    {
        if (!$user) {
            return [
                'id' => null,
                'username' => null,
                'name' => null,
                'type' => 'system'
            ];
        }

        $guard = $guard ?? self::getCurrentGuard();
        
        if ($guard === 'admin') {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->username, // Admin hanya punya username
                'type' => 'admin'
            ];
        } elseif ($guard === 'web') {
            // For web guard, try to get employee name from related table
            $userDetails = [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->username, // Default to username
                'type' => 'user'
            ];

            // Try to get employee name if id_pegawai exists
            if (isset($user->id_pegawai) && $user->id_pegawai) {
                try {
                    $pegawai = \App\Models\Pegawai::find($user->id_pegawai);
                    if ($pegawai) {
                        $userDetails['name'] = $pegawai->nama;
                        $userDetails['employee_id'] = $pegawai->id;
                        $userDetails['employee_nik'] = $pegawai->nik;
                    }
                } catch (\Exception $e) {
                    // If error, keep default values
                }
            }

            return $userDetails;
        }

        return [
            'id' => null,
            'username' => null,
            'name' => null,
            'type' => 'unknown'
        ];
    }
} 