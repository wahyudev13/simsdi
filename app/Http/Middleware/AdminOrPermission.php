<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        // Jika login via guard 'admin', lolos tanpa cek permission
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->can($permission)) {
            // User login biasa + punya permission
            return $next($request);
        }

        // Jika login via guard lain, cek permission
        if (! $request->user() || !$request->user()->can($permission)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
