<?php

namespace App\Livewire\Customer\Profile;

use App\Models\User;
use App\Models\Address;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $user;
    public $addresses;

    public ?int $quantity = 5;

    public ?string $search = null;

    public array $sort = [
        'column'    => 'is_default',
        'direction' => 'desc',
    ];

    public array $headers = [
        ['index' => 'type', 'label' => 'Type'],
        ['index' => 'label', 'label' => 'Label'],
        ['index' => 'address', 'label' => 'Address'],
        ['index' => 'is_default', 'label' => 'Default'],
        ['index' => 'action', 'sortable' => false],
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->addresses = Address::where('user_id',$this->user->id)->get();
    }

    public function render(): View
    {
        return view('livewire.customer.profile.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Address::query()
            ->with('city','state','county')
            ->where('user_id', [Auth::id()])
            ->when($this->search !== null, fn (Builder $query) => $query->whereAny(['line1', 'line2','city','state','postal_code','country'], 'like', '%'.trim($this->search).'%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}