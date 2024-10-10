<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('superadmin')->check()||Auth::guard('superadmin')->user()->role !== 'superadmin') {
            return redirect('/superadmin')->with('error', 'You must be logged in as a superadmin to access this page.'); // Ensure this route exists
        }
        return $next($request);
    }
}
