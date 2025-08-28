<?php

namespace App\Livewire\Order;

use App\Models\Order;
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
        ['index' => 'user_id', 'label' => 'User'],
        ['index' => 'order_number', 'label' => 'Order #'],
        ['index' => 'order_type', 'label' => 'Type'],
        ['index' => 'order_status', 'label' => 'Status'],
        ['index' => 'payment_status', 'label' => 'Payment Status'],
        ['index' => 'paid_amount', 'label' => 'Paid Amount'],
        ['index' => 'total_amount', 'label' => 'Total'],
        ['index' => 'action'],
    ];

    public function render()
    {
        return view('livewire.order.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Order::query()
            ->with('items','user')
            ->when(
                $this->search !== null, 
                fn (Builder $query) => $query
                ->whereAny(['order_type','order_status','payment_status','total_amount'], 'like', '%'.trim($this->search).'%')
                ->orWhereHas('user', function($query){
                    $query->where('name', 'like', '%'.trim($this->search).'%');
                })
            )
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}