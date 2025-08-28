<?php

namespace App\Livewire\Product;

use App\Models\Product;
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
        ['index' => 'name', 'label' => 'Name'],
        ['index' => 'code', 'label' => 'Product Code'],
        ['index' => 'category', 'label' => 'Category'],
        ['index' => 'price', 'label' => 'Price'],
        ['index' => 'cost', 'label' => 'Cost'],
        ['index' => 'quantity', 'label' => 'Quantity'],
        ['index' => 'sku', 'label' => 'SKU'],
        ['index' => 'action'],
    ];

    public function render()
    {
        return view('livewire.product.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Product::query()
            ->with('category','images')
            ->when(
                $this->search !== null, 
                fn (Builder $query) => $query
                ->whereAny(['name','code','price','cost','sku'], 'like', '%'.trim($this->search).'%')
                ->orWhereHas('category', function($query){
                    $query->where('name', 'like', '%'.trim($this->search).'%');
                })
            )
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
