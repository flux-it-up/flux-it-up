<?php

namespace App\Livewire\Admin\TaxRates;

use Livewire\Component;
use App\Models\State as StateModel;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

class State extends Component
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
        ['index' => 'code', 'label' => 'Code'],
        ['index' => 'name', 'label' => 'State'],
        ['index' => 'tax_rate', 'label' => 'Tax Rate'],
        ['index' => 'sales_threshold', 'label' => 'Sales Threshold'],
        ['index' => 'transaction_threshold', 'label' => 'Transaction Threshold'],
        ['index' => 'action'],
    ];

    public function render()
    {
        return view('livewire.admin.tax-rates.state');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return StateModel::query()
            ->with('thresholds')
            ->when($this->search !== null, fn (Builder $query) => $query->whereAny(['name','code','tax_rate'], 'like', '%'.trim($this->search).'%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
