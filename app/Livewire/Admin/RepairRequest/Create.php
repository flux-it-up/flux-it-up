<?php

namespace App\Livewire\Admin\RepairRequest;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use App\Models\RepairRequest;
use App\Models\User;
use App\Models\Service;
use App\Models\Console;
use App\Models\Order;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Alert, Interactions;

    public RepairRequest $repair;
    public $users, $consoles, $technicians;
    public $services = [];
    public $selectedConsole = '';
    public $selectedServices = [];
    public $servicePrice = 0;

    public bool $modal = false;

    public function mount(): void 
    {
        $this->repair = new RepairRequest();
        $this->repair->repair_status = 'received';
        $this->repair->priority = 'normal';
        $this->consoles = Console::all();
        $this->users = User::all();
        $this->technicians = User::role('technician')->get();
    }

    public function updatedSelectedConsole()
    {
        if($this->selectedConsole) {
            $this->services = Service::whereHas('consoles', function($query) {
                $query->where('console_id', $this->selectedConsole);
            })->get();
        }
        $this->selectedServices = [];
        $this->servicePrice = 0;
    }

    protected $rules = [
        'repair.user_id' => 'required|exists:users,id',
        'selectedConsole' => 'required|exists:consoles,id',
        'selectedServices' => 'required|array|min:1',
        'repair.console_serial_number' => 'nullable|string|max:100',
        'repair.issue_description' => 'required|string|min:10|max:1000',
        'repair.customer_notes' => 'nullable|string|max:500',
        'repair.repair_status' => 'required|in:received,diagnosed,approved,in_progress,completed,quality_check,ready,shipped,delivered',
        'repair.priority' => 'required|in:low,normal,high,urgent',
        'repair.estimated_completion' => 'nullable',
        'repair.technician_id' => 'nullable',
        'repair.warranty_expires' => 'nullable',
    ];

    public function save()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            logger()->error('Validation failed: '.$e->getMessage());
        }

        foreach($this->selectedServices as $serviceId) {
            $service = Service::find($serviceId);
            if($service) {
                $this->servicePrice += $service->price;
            }
        }

        $order = Order::create([
            'user_id' => $this->repair->user_id,
            'order_type' => 'repair',
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => $this->servicePrice,
            'total_amount' => $this->servicePrice,
            'currency' => 'USD',
        ]);

        $this->repair->order_id = $order->id;
        $this->repair->user_id = $this->repair->user_id;
        $this->repair->console_id = $this->selectedConsole;
        $this->repair->console_serial_number = $this->repair->console_serial_number;
        $this->repair->issue_description = $this->repair->issue_description;
        $this->repair->customer_notes = $this->repair->customer_notes;
        $this->repair->repair_status = $this->repair->repair_status;
        $this->repair->priority = $this->repair->priority;
        $this->repair->repair_cost = $this->servicePrice;
        $this->repair->total_cost = $this->servicePrice;
        $this->repair->estimated_completion = $this->repair->estimated_completion;
        $this->repair->technician_id = $this->repair->technician_id;
        $this->repair->warranty_expires = $this->repair->warranty_expires;
        
        $this->repair->save();
        
        foreach($this->selectedServices as $serviceId) {
            $this->repair->services()->attach($serviceId);
        }
        
        $this->dispatch('created');
        $this->dispatch('notification-sent');

        $this->resetExcept('consoles','users','technicians');
        $this->repair = new RepairRequest();

        $this->toast()->success('Repair Request created successfully!')->send();
    }

    public function render()
    {
        return view('livewire.admin.repair-request.create');
    }
}
