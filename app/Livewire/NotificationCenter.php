<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\Alert;

class NotificationCenter extends Component
{
    use WithPagination, Alert;

    public $filter = 'all';

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

    public function deleteNotification($notificationId)
    {
       if(!Auth::check()) {
            return;
        }

        $notification = Auth::user()->notifications()
            ->where('id', $notificationId)
            ->first();

        if($notification) {
            $notification->delete();
            $this->resetPage();
            $this->toast()->info('Notification deleted')->send();
        }
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

        return view('livewire.notification-center', [
            'notifications' => $notifications
        ]);
    }
}
