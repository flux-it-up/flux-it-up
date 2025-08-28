<?php

namespace App\Livewire\Service;

use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
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
        ['index' => 'description', 'label' => 'Description'],
        ['index' => 'code', 'label' => 'Service Code'],
        ['index' => 'consoles', 'label' => 'Consoles'],
        ['index' => 'base_price', 'label' => 'Base Price'],
        ['index' => 'estimated_time', 'label' => 'Estimated Time'],
        ['index' => 'sku', 'label' => 'SKU'],
        ['index' => 'action'],
    ];

    public function render()
    {
        return view('livewire.service.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Service::query()
            ->with('consoles')
            ->when($this->search !== null, fn (Builder $query) => $query->whereAny(['name','description','code','sku'], 'like', '%'.trim($this->search).'%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
