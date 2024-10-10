<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\WhiteList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserLogin extends Controller
{
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
            $clientIp = $request->ip();
        if (!WhiteList::where('ip_address', $clientIp)->exists()) {
            return redirect('/login')->with('error', 'Your IP is not whitelisted.');
        }
    
       $user = User::where('username', $credentials['username'])->first();
        
    //    if(Auth::guard('admin')->check()){
    //        return redirect('/login')->with('error', 'Simultaneously logged in device. Please logout first.');

    //    } else if(Auth::guard('cashier')->check()){
    //        return redirect('/login')->with('error', 'Simultaneously logged in device. Please logout first.');
    //    } 
       if(Auth::id()){
           return redirect('/login')->with('error', 'Simultaneously logged in device. Please logout first.');
       }
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return redirect('/login')->with('error', 'Invalid Credentials');
        }
    
        if ($user->archive == 1) {
            return redirect('/login')->with('error', 'Your account is archived, please contact the admin.');
        }
    
        switch ($user->role) {
            case 'admin':
                if (Auth::guard('admin')->attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect('/admin/dashboard')->with('success', 'Login Successful as Admin');
                }
                break;
    
            case 'cashier':
                if (Auth::guard('cashier')->attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect('/cashier/pos')->with('success', 'Login Successful as Cashier');
                }
                break;
    
            default:
                return redirect('/login')->with('error', 'Unauthorized role');
        }
    
        return redirect('/login')->with('error', 'Invalid Credentials');
}
    

   
    
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('user.login')->with('success', 'Logout Successful');
}

}
