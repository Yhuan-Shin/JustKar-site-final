<?php

namespace App\Http\Controllers;
use App\Models\WhiteList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WhiteListController extends Controller
{
    //
    public function display()
    {   
        $whitelists = WhiteList::ALl();
        return view('superadmin/superadmin-config',['whitelists' => $whitelists]);
    }
    public function store(Request $request){

        $data = $request->validate([
            'ip_address' => 'required|string',
        ]);
        WhiteList::create($data);
        return redirect('/superadmin/system_config')->with('success', 'White Listed');
    }
    public function update(Request $request, $id){
        $data = $request->validate([
            'ip_address' => 'required|string',
        ]);
        $whitelist = WhiteList::find($id);
        $whitelist->update($data);
        return redirect('/superadmin/system_config')->with('success', 'Updated');
    }
    public function destroy($id){
        $whitelist = WhiteList::find($id);
        $whitelist->delete();
        return redirect('/superadmin/system_config')->with('success', 'Deleted');
    }
}
