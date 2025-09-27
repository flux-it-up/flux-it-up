<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\Alert;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];
    public $showDropdown = false;
    public $filter = 'recent';
    public $mobile = false;
    public $compact = false;
    public $user;

    public function mount($mobile = false, $compact = false)
    {
        $this->user = Auth::user();
        $this->mobile = $mobile;
        $this->compact = $compact;
        $this->loadNotifications();
    }

    public function getListeners()
    {
        $userId = Auth::id();

        $listeners = [
            'notification-sent' => 'handleNewNotification',
            'refresh-notifications' => 'loadNotifications',
        ];

        if(Auth::check()) {
            $listeners["echo:notifications.{$userId},Illuminate\\Notifications\\Events\\BroadcastNotificationCreated"] = 'handleBroadcastNotification';
        }

        return $listeners;
    }

    #[On('notification-sent')]
    public function refreshNotifications()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if(!Auth::check()) {
            $this->unreadCount = 0;
            $this->notifications = [];
            return;
        }

        $this->unreadCount = $this->user->unreadNotifications->count();

        $query = $this->user->notifications()->latest();
        
        // Apply filter
        match($this->filter) {
            'unread' => $query->unread(),
            'high_priority' => $query->highPriority(),
            'needs_attention' => $query->needsAttention(),
            'today' => $query->today(),
            'recent' => $query->recent(7),
            'with_action' => $query->withAction(),
            'order_updates' => $query->orderNotifications(),
            'urgent' => $query->colors(['red', 'yellow'])->unread(),
            default => $query
        };
        
        $limit = $this->compact ? 5 : 10;

        $this->notifications = $query->limit($limit)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title ?? 'Notification',
                    'message' => $notification->data['message'] ?? '',
                    'icon' => $notification->icon ?? 'bell',
                    'color' => $notification->color ?? 'blue',
                    'action_url' => $notification->action_url ?? null,
                    'action_text' => $notification->action_text ?? null,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            });
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;

        if($this->showDropdown) {
            $this->loadNotifications();
        }
    }

    public function closeDropdown()
    {
        $this->showDropdown = false;
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->loadNotifications();
    }

    public function markAsRead($notificationId)
    {
        if(!Auth::check()) {
            return;
        }

        $notification = $this->user->notifications()
            ->where('id', $notificationId)
            ->whereNull('read_at')
            ->first();

        if($notification) {
            $notification->update(['read_at' => now()]);

            $this->dispatch('notification-read', notificationId: $notificationId);
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        if(!Auth::check()) {
            return;
        }

        $count = $this->user->unreadNotifications->count();
        if($count > 0) {
            $this->user->unreadNotifications->markAsRead();
            $this->loadNotifications();
            $this->toast()->info('Marked {$count} notifications as read')->send();
        }
    }

    public function deleteNotification($notificationId)
    {
        if(!Auth::check()) {
            return;
        }

        $notification = $this->user->notifications()
            ->where('id', $notificationId)
            ->first();

        if($notification) {
            $notification->delete();
            $this->loadNotifications();
            $this->toast()->info('Notification deleted')->send();
        }
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }

    public function handleBroadcastNotification($event)
    {
        $this->loadNotifications();

        $this->dispatch('toast', [
            'type' => 'info',
            'title' => $event['title'],
            'message' => $event['message']
        ]);
    }

    public function handleNotificationClick($notificationId, $actionUrl = null)
    {
        $this->markAsRead($notificationId);

        if($actionUrl) {
            $this->closeDropdown();
            return redirect($actionUrl);
        }
    }

    public function goToNotificationCenter()
    {
        $this->closeDropdown();
        return redirect()->route('notifications.index');
    }

    public function handleNewNotification($notification)
    {
        $this->loadNotifications();
    }
}
