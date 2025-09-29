<?php

namespace App\Livewire\Admin\Service\Category;

use Livewire\Component;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Index extends Component
{
    use WithPagination;

    public ?ServiceCategory $category;

    public ?int $quantity = 25;

    public ?string $search = null;

    public array $sort = [
        'column'    => 'id',
        'direction' => 'asc',
    ];

    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'name', 'label' => 'Name'],
        ['index' => 'description', 'label' => 'Description'],
        ['index' => 'action', 'sortable' => false],
    ];

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return ServiceCategory::query()
            ->when($this->search !== null, fn (Builder $query) => $query->whereAny(['name', 'description'], 'like', '%'.trim($this->search).'%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }

    public function render()
    {
        return view('livewire.admin.service.category.index');
    }
}
