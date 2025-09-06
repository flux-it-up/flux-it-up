<?php

namespace App\Livewire\Console;

use Livewire\Component;
use App\Models\Console;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Index extends Component
{
    use WithPagination;

    public ?Console $console;

    public ?int $quantity = 25;

    public ?string $search = null;

    public array $sort = [
        'column'    => 'id',
        'direction' => 'asc',
    ];

    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'image', 'label' => 'Image'],
        ['index' => 'brand', 'label' => 'Brand'],
        ['index' => 'model', 'label' => 'Model'],
        ['index' => 'model_number', 'label' => 'Model Number'],
        ['index' => 'release_year', 'label' => 'Release Year'],
        ['index' => 'code', 'label' => 'Code'],
        ['index' => 'action', 'sortable' => false],
    ];

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Console::query()
            ->when($this->search !== null, fn (Builder $query) => $query->whereAny(['brand', 'model', 'model_number', 'release_year'], 'like', '%'.trim($this->search).'%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }

    public function render()
    {
        return view('livewire.console.index');
    }
}
