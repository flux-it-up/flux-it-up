<?php

namespace App\Livewire\Admin\TaxRates;

use Livewire\Component;
use App\Models\State;
use App\Models\County as CountyModel;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

class County extends Component
{
    use WithPagination;

    public State $state;

    public $options;

    public ?int $quantity = 25;

    public ?string $search = null;

    public array $sort = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    public array $headers = [
        ['index' => 'name', 'label' => 'County'],
        ['index' => 'tax_rate', 'label' => 'Tax Rate'],
        ['index' => 'action'],
    ];

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        if($this->state) {
            return CountyModel::query()->where('state_id',$this->state->id)
            ->when($this->search !== null, fn (Builder $query) => $query->whereAny(['name','tax_rate'], 'like', '%'.trim($this->search).'%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
        } else {
            return null;
        }
        
    }

    public function render()
    {
        return view('livewire.admin.tax-rates.county');
    }
}
