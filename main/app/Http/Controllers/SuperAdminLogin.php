<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;

class SuperAdminLogin extends Controller
{
    //
    public function login(Request $request)
    {
        if (Auth::guard('superadmin')->check()) {
            return redirect('/superadmin')->with('error', 'You are already logged in.');
        }
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if (Auth::guard('superadmin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/superadmin/user_management')->with('success', 'Login Successful');
        } else {
            return redirect('/superadmin')->with('error', 'Invalid Credentials');
        }
    }
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|string']);
    
        $superadmin = Superadmin::where('email', $request->email)->first();
    
        if (!$superadmin) {
            return back()->withErrors(['email' => 'Superadmin with this email not found']);
        }
    
        $status = Password::broker('superadmin')->sendResetLink(
            ['email' => $superadmin->email]
        );
    
        return $status == Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
    
    public function showResetForm($token)
    {
        return view('superadmin.reset-password')->with(
            ['token' => $token , 'email' => request('email')]
        );
    }
    
    public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:superadmin,email',
        'password' => 'required|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/',
        'token' => 'required'
        ,[
            'password.regex' => 'The password must contain at least one letter, one number, and one special character.',
        
        ]
    ]);

    if($request->password != $request->password_confirmation){
        return back()->withErrors(['password' => 'Password do not match']);
    } else if(!Superadmin::where('email', $request->email)->exists()){
        return back()->withErrors(['email' => 'Email do not match']);
    }

    $status = Password::broker('superadmin')->reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($superadmin, $password) {
            $superadmin->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $superadmin->save();
        });

    return $status == Password::PASSWORD_RESET 
        ? redirect('/superadmin')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);

}

    



    public function logout()
    {
        Auth::guard('superadmin')->logout();
        return redirect('/superadmin');
    }
}
