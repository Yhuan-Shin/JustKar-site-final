<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Session;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (!Auth::guard('admin')->check()||Auth::guard('admin')->user()->role !== 'admin') {
            return redirect('/login')->with('error', 'You must be logged in as a admin to access this page.'); // Ensure this route exists
        }
        return $next($request);
    }
}
