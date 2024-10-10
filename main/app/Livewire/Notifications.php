<?php

namespace App\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class Notifications extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $superadmin = Auth::guard('superadmin')->user();        
        $notifications = $superadmin->unreadNotifications()->paginate(10);
        return view('livewire.notifications' , ['notifications' => $notifications]);
    }
}
