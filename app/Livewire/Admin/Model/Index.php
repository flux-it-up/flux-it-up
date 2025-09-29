<?php

namespace App\Livewire\Admin\Model;

use Livewire\Component;
use App\Models\ConsoleModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Index extends Component
{
    use WithPagination;

    public ?ConsoleModel $model;

    public ?int $quantity = 25;

    public ?string $search = null;

    public array $sort = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'console', 'label' => 'Console'],
        ['index' => 'model', 'label' => 'Model Number'],
        ['index' => 'release_year', 'label' => 'Release Year'],
        ['index' => 'storage_capacity', 'label' => 'Storage Capacity'],
        ['index' => 'action', 'sortable' => false],
    ];

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return ConsoleModel::query()
            ->with('console')
            ->when(
                $this->search !== null, 
                fn (Builder $query) => $query
                ->whereAny(['model', 'release_year','storage_capacity'], 'like', '%'.trim($this->search).'%')
                ->orWhereHas('console', function($query){
                    $query->where('name', 'like', '%'.trim($this->search).'%');
                })
            )
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }

    public function render()
    {
        return view('livewire.admin.model.index');
    }
}
