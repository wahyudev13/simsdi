<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MultiplePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $permissions  Comma-separated list of permissions
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        // Check if user is authenticated from either guard
        $user = auth()->user() ?? auth('admin')->user();
        
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 401,
                    'error' => ['auth' => ['User tidak terautentikasi']]
                ], 401);
            }
            return redirect('/');
        }

        // Admin guard bypass permission check (has all access)
        if (auth('admin')->check()) {
            return $next($request);
        }
        
        // For web guard, check if user has any of the required permissions
        $hasPermission = false;
        foreach ($permissions as $permission) {
            if ($user->hasPermissionTo($permission)) {
                $hasPermission = true;
                break;
            }
        }

        if (!$hasPermission) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 403,
                    'error' => ['permission' => ['Anda tidak memiliki izin untuk melakukan aksi ini']]
                ], 403);
            }
            
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
} 