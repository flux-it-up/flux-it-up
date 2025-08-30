<?php

namespace App\Livewire\RepairRequest;

use App\Livewire\Traits\Alert;
use App\Models\RepairRequest;
use App\Models\Service;
use App\Models\Console;
use App\Models\User;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use Alert;
    
    public ?RepairRequest $repair;
    public $users, $consoles;
    public $services = [];
    public $selectedConsole = '';
    public $selectedService = '';
    public $servicePrice = 0;

    public bool $modal = false;

    public function mount()
    {
        $this->consoles = Console::all();
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.repair-request.update');
    }

    #[On('load::repair')]
    public function load(RepairRequest $repair): void
    {
        $this->repair = $repair;
        $this->selectedConsole = $this->repair->console_id;
        $this->updatedSelectedConsole(); // preload services
        $this->selectedService = $this->repair->service_id;
        $this->modal = true;
        
        $this->updatedSelectedService(); // preload price
    }

    public function updatedSelectedConsole()
    {
        if($this->selectedConsole) {
            $this->services = Service::whereHas('consoles', function($query) {
                $query->where('console_id', $this->selectedConsole);
            })->get();
        }
        $this->selectedService = '';
        $this->servicePrice = 0;
    }

    public function updatedSelectedService()
    {
        if($this->selectedService) {
            $service = Service::find($this->selectedService);
            $pivot = $service->consoles()->where('console_id', $this->selectedConsole)->first()->pivot;
            $servicePriceAdj = $pivot->price_adjustment;
            $this->servicePrice = $service->base_price + $servicePriceAdj;
        }
    }

    protected $rules = [
        'repair.user_id' => 'required|exists:users,id',
        'selectedConsole' => 'required|exists:consoles,id',
        'selectedService' => 'required|exists:services,id',
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
        $this->validate();

        $order = Order::findOrFail($this->repair->order_id);

        if($order) {
            $order->save([
                'user_id' => $this->repair->user_id,
                'order_type' => 'repair',
                'order_status' => 'pending',
                'payment_status' => 'pending',
                'subtotal' => $this->servicePrice,
                'total_amount' => $this->servicePrice,
                'currency' => 'USD',
            ]);
        }

        $this->repair->user_id = $this->repair->user_id;
        $this->repair->console_id = $this->selectedConsole;
        $this->repair->service_id = $this->selectedService;
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
        
        $this->dispatch('updated');

        $this->selectedConsole = '';
        $this->selectedService = '';

        $this->resetExcept('repair','consoles','users','selectedConsole','selectedService');

        $this->toast()->success('Repair Request updated successfully!')->send();
    }
}
