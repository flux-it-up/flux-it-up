<?php

namespace App\Livewire\User;

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

    public $states = [
            ['label' => 'Alabama', 'value' => 'AL'],
            ['label' => 'Alaska', 'value' => 'AK'],
            ['label' => 'Arizona', 'value' => 'AZ'],
            ['label' => 'Arkansas', 'value' => 'AR'],
            ['label' => 'California', 'value' => 'CA'],
            ['label' => 'Canal Zone', 'value' => 'CZ'],
            ['label' => 'Colorado', 'value' => 'CO'],
            ['label' => 'Connecticut', 'value' => 'CT'],
            ['label' => 'Delaware', 'value' => 'DE'],
            ['label' => 'District of Columbia', 'value' => 'DC'],
            ['label' => 'Florida', 'value' => 'FL'],
            ['label' => 'Georgia', 'value' => 'GA'],
            ['label' => 'Guam', 'value' => 'GU'],
            ['label' => 'Hawaii', 'value' => 'HI'],
            ['label' => 'Idaho', 'value' => 'ID'],
            ['label' => 'Illinois', 'value' => 'IL'],
            ['label' => 'Indiana', 'value' => 'IN'],
            ['label' => 'Iowa', 'value' => 'IA'],
            ['label' => 'Kansas', 'value' => 'KS'],
            ['label' => 'Kentucky', 'value' => 'KY'],
            ['label' => 'Louisiana', 'value' => 'LA'],
            ['label' => 'Maine', 'value' => 'ME'],
            ['label' => 'Maryland', 'value' => 'MD'],
            ['label' => 'Massachusetts', 'value' => 'MA'],
            ['label' => 'Michigan', 'value' => 'MI'],
            ['label' => 'Minnesota', 'value' => 'MN'],
            ['label' => 'Mississippi', 'value' => 'MS'],
            ['label' => 'Missouri', 'value' => 'MO'],
            ['label' => 'Montana', 'value' => 'MT'],
            ['label' => 'Nebraska', 'value' => 'NE'],
            ['label' => 'Nevada', 'value' => 'NV'],
            ['label' => 'New Hampshire', 'value' => 'NH'],
            ['label' => 'New Jersey', 'value' => 'NJ'],
            ['label' => 'New Mexico', 'value' => 'NM'],
            ['label' => 'New York', 'value' => 'NY'],
            ['label' => 'North Carolina', 'value' => 'NC'],
            ['label' => 'North Dakota', 'value' => 'ND'],
            ['label' => 'Ohio', 'value' => 'OH'],
            ['label' => 'Oklahoma', 'value' => 'OK'],
            ['label' => 'Oregon', 'value' => 'OR'],
            ['label' => 'Pennsylvania', 'value' => 'PA'],
            ['label' => 'Puerto Rico', 'value' => 'PR'],
            ['label' => 'Rhode Island', 'value' => 'RI'],
            ['label' => 'South Carolina', 'value' => 'SC'],
            ['label' => 'South Dakota', 'value' => 'SD'],
            ['label' => 'Tennessee', 'value' => 'TN'],
            ['label' => 'Texas', 'value' => ''],
            ['label' => 'Utah', 'value' => ''],
            ['label' => 'Vermont', 'value' => ''],
            ['label' => 'Virgin Islands', 'value' => ''],
            ['label' => 'Virginia', 'value' => ''],
            ['label' => 'Washington', 'value' => ''],
            ['label' => 'West Virginia', 'value' => ''],
            ['label' => 'Wisconsin', 'value' => ''],
            ['label' => 'Wyoming', 'value' => ''],
        ];

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

    public function __construct()
    {
        $this->user = Auth::user();
        $this->addresses = Address::where('user_id',$this->user->id)->get();
    }

    public function render(): View
    {
        return view('livewire.user.index');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return Address::query()
            ->where('user_id', [Auth::id()])
            ->when($this->search !== null, fn (Builder $query) => $query->whereAny(['line1', 'line2','city','state','postal_code','country'], 'like', '%'.trim($this->search).'%'))
            ->orderBy(...array_values($this->sort))
            ->paginate($this->quantity)
            ->withQueryString();
    }
}