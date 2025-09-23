<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use App\Livewire\Traits\Alert;
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\Layout;

// Models
use App\Models\User;
use App\Models\RepairRequest as Repair;
use App\Models\Console;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    use Alert, Interactions, WithPagination;

    public User $user;
    public $stats = [];
    public $recentOrders = [];
    public $notifications = [];

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadStats();
        $this->loadRecentOrders();
        $this->loadNotifications();
    }

    public function loadStats()
    {
        if($this->user->hasAnyRole(['admin', 'super-admin', 'technician', 'support', 'manager'])) {
            $this->stats = [
                'total_orders' => Repair::count(),
                'pending_orders' => Repair::where('repair_status','pending')->count(),
                'completed_orders' => Repair::where('repair_status','completed')->count(),
                'total_customers' => User::role('customer')->count(),
                'revenue_this_month' => Repair::where('repair_status','completed')->whereMonth('created_at', now()->month)->sum('total_cost'),
            ];
        } else {
            $this->stats = [
                'my_orders' => Repair::where('user_id', $this->user->id)->count(),
                'pending_repairs' => Repair::where('user_id', $this->user->id)->whereIn('repair_status',['pending','in_progress'])->count(),
                'completed_repairs' => Repair::where('user_id', $this->user->id)->where('repair_status','completed')->count(),
                'total_spent' => Repair::where('user_id', $this->user->id)->where('repair_status','completed')->sum('total_cost'),
            ];
        }
    }

    public function loadRecentOrders()
    {
        if($this->user->hasAnyRole(['admin', 'super-admin', 'technician', 'support', 'manager'])) {
            $this->recentOrders = Repair::with(['user','console'])->latest()->take(5)->get();
        } else {
            $this->recentOrders = Repair::with('console')->where('user_id',$this->user->id)->latest()->take(5)->get();
        }
    }

    public function loadNotifications()
    {
        if($this->user->hasAnyRole(['admin', 'super-admin', 'technician', 'support', 'manager'])) {
            $this->notifications = [
                'New orders awaiting confirmation',
                'Low inventory alerts',
                'Customer messages pending response',
            ];
        } else {
            $this->notifications = [
                'Repair status updates',
                'Special offers available',
                'Warranty reminders',
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}