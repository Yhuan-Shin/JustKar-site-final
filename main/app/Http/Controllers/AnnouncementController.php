<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AnnouncementController extends Controller
{
    //
    public function display(){
        $announcements = Announcement::all();
        return view('admin/admin-announcement', compact('announcements'));
    }
    public function displayOnCustomers(){
        $announcements = Announcement::all();
        return view('index',['announcements' => $announcements]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $announcements = new Announcement();
        $announcements->title = $request->input('title');
        $announcements->content = $request->input('content');
        if($request->hasFile('image')){
            $destination = 'uploads/images'.$announcements -> image;
            if(file_exists($destination)){
                @unlink($destination);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/images', $filename);
            $announcements->image = $filename; 
        }
        $announcements->save();
      
        return redirect('/admin/announcements')->with('success', 'Post Added') ;
    }
    public function edit(string $id): View
    {
        $announcements = Announcement::find($id);
        return view('inventory.edit')->with('announcements', $announcements);
    }
    public function update(Request $request, string $id)
    {
        $announcements = Announcement::find($id);
        $announcements->title = $request->input('title');
        $announcements->content = $request->input('content');
        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/images', $filename);
            $announcements->image = $filename; 
        }
        $announcements->save();
      
        return redirect('/admin/announcements')->with('success', 'Post Updated') ;
    }
    public function destroy(string $id): RedirectResponse
    {
        Announcement::destroy('delete from announcement where id = ?',[$id]);
        return redirect('/admin/announcements')->with('success', 'Post deleted!'); 
    }

}
