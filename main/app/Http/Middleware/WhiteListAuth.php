<?php

namespace App\Http\Middleware;
use App\Models\WhiteList;
use Closure;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use App\Notifications\UnauthorizedAccessNotification;
use Symfony\Component\HttpFoundation\Response;

class WhiteListAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $clientIp = $request->ip();

        $whitelistIps = Whitelist::pluck('ip_address')->toArray();
        
        if (!in_array($clientIp, $whitelistIps)) {
            // Return an HTML response for unauthorized access
            $superAdmin = SuperAdmin::where('role', 'superadmin')->first();
            if ($superAdmin) {
                $superAdmin->notify(new UnauthorizedAccessNotification($clientIp));
            }
            return response()->view('errors.error_message', [
                'ip_address' => $clientIp
            ], 401); 
        }
        
        // Proceed with the request if IP is whitelisted
        return $next($request);
    }
}
