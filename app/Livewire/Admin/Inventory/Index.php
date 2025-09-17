<?php

namespace App\Livewire\Admin\Inventory;

use App\Models\Inventory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;use Livewire\Component;

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
        ['index' => 'product', 'label' => 'Product'],
        ['index' => 'quantity', 'label' => 'Quantity'],
        ['index' => 'min_quantity', 'label' => 'Minimum Quantity'],
        ['index' => 'location', 'label' => 'Location'],
        ['index' => 'last_restock', 'label' => 'Last Restock'],
        ['index' => 'action'],
    ];

    public function render()
    {
        return view('livewire.admin.inventory.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Inventory::query()
            ->with('product')
            ->when(
                $this->search !== null, 
                fn (Builder $query) => $query
                ->whereHas('product', function($query){
                        $query->where('name', 'like', '%'.trim($this->search).'%');
                    })
            )
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}