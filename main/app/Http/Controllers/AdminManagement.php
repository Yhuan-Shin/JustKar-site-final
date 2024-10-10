<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Models\WhiteList;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class AdminManagement extends Controller
{
    //
    public function display(){
        $admins = User::where('role', 'admin')->get();
        return view('superadmin/superadmin-user', ['admins' => $admins]);
    }
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'role'=>'required',
            'password' => 'required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/'
            ],[
                'password.regex' => 'The password must contain at least one letter, one number, and one special character.',
            
            ],
           
        );
        if(User::where('username', $data['username'])->exists() && $data['role'] == 'admin'){
            return redirect('/superadmin/user_management')->with('error', 'Username already taken');
        }
        User::create($data);
        return redirect('/superadmin/user_management')->with('success', 'Admin Added');
        


    }
    public function archive(string $id): RedirectResponse   
    {
        $admin = User::where('id', $id)->where('role', 'admin')->firstOrFail();
        $admin->archive = 1;
        $admin->save();
        return redirect('/superadmin/user_management')->with('success', 'Admin Archived');
    }
    public function restore(string $id): RedirectResponse
    {
        $admin = User::where('id', $id)->where('role', 'admin')->firstOrFail();
        $admin->archive = 0;
        $admin->save();
        return redirect('/superadmin/user_management')->with('success', 'Admin Restored');
    }
    public function update(Request $request, string $id)
    {
       try{
        $admins = User::where('id', $id)->where('role', 'admin')->firstOrFail();
        $admins->update($request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:admin,username,'.$id,
            'password' => 'required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/'
            ],[
                'password.regex' => 'The password must contain at least one letter, one number, and one special character.',
            
            ])
        );
        return redirect('/superadmin/user_management')->with('success', 'Admin Updated');
       }catch (QueryException $e) {
        if ($e->errorInfo[1] == 1062) { // MySQL error code for duplicate entry
            return redirect('/superadmin/user_management')->with('error', 'Duplicate entry for username. Please use a different username.');
        } else {
            // Handle other query exceptions or rethrow the exception
            throw $e;
        }
       }
    }
    public function destroy(string $id): RedirectResponse
    {
        User::destroy('delete from users where id = ? and role = admin',[$id] ) ;
        return redirect('/superadmin/user_management')->with('success', 'Account deleted!'); 
    }
   

}
