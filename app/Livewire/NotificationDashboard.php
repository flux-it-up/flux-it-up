<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\Alert;
use Livewire\Attributes\Renderless;

class NotificationDashboard extends Component
{
    use Alert;

    public $filter = 'unread';

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if($notification && !$notification->read_at) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        $query = Auth::user()->notifications();

        if($this->filter === 'unread') {
            $query->whereNull('read_at');
        } elseif($this->filter === 'read') {
            $query->whereNotNull('read_at');
        }

        $notifications = $query->latest()->paginate(15);

        return view('livewire.notification-dashboard', [
            'notifications' => $notifications
        ]);
    }
}
