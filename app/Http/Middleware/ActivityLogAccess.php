<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated (either web or admin guard)
        if (!Auth::check() && !Auth::guard('admin')->check()) {
            return redirect('/');
        }

        // Get the authenticated user from either guard
        $user = Auth::user() ?? Auth::guard('admin')->user();
        
        // If admin guard is authenticated, allow access (bypass permission check)
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }
        
        // For web guard users, check permission
        if (!$user || !$user->hasPermissionTo('admin-all-access')) {
            abort(403, 'Unauthorized access to activity log.');
        }

        return $next($request);
    }
} 