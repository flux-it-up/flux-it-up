<?php

namespace App\Livewire\PricingTier;

use App\Models\PricingTier;
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

    public $id;

    public ?int $quantity = 25;

    public ?string $search = null;

    public array $sort = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'name', 'label' => 'Name'],
        ['index' => 'services', 'label' => 'Services'],
        ['index' => 'price', 'label' => 'Price'],
        ['index' => 'warranty', 'label' => 'Warranty'],
        ['index' => 'estimated_time', 'label' => 'Estimated Time'],
        ['index' => 'action'],
    ];

    public function render()
    {
        return view('livewire.pricing-tier.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return PricingTier::query()
            ->with('services')
            ->when($this->search !== null, fn (Builder $query) => $query->whereAny(['name', 'email'], 'like', '%'.trim($this->search).'%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
