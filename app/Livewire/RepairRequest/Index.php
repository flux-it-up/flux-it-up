<?php

namespace App\Livewire\RepairRequest;

use App\Models\RepairRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public $options;

    public ?int $quantity = 25;

    public ?string $search = null;

    public array $sort = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'user', 'label' => 'User'],
        ['index' => 'order_number', 'label' => 'Order #'],
        ['index' => 'console', 'label' => 'Console'],
        ['index' => 'service', 'label' => 'Service'],
        ['index' => 'repair_status', 'label' => 'Repair Status'],
        ['index' => 'priority', 'label' => 'Priority'],
        ['index' => 'technician', 'label' => 'Technician'],
        ['index' => 'action'],
    ];

    public function render()
    {
        return view('livewire.repair-request.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return RepairRequest::query()
            ->with('order','user','console','service')
            ->when(
                $this->search !== null, 
                fn (Builder $query) => $query
                ->whereAny([], 'like', '%'.trim($this->search).'%')
                ->orWhereHas('user', function($query){
                    $query->where('name', 'like', '%'.trim($this->search).'%');
                })
            )
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
