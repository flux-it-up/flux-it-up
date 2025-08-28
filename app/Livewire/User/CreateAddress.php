<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use App\Models\Address;

class CreateAddress extends Component
{
    use Alert;

    public $addresses;
    public $type = 'shipping';
    public $label;
    public $line1;
    public $line2;
    public $city;
    public $state;
    public $states;
    public $postal_code;
    public $country;
    public $is_default = false;

    public bool $modal = false;

    public function mount()
    {
        $this->states = [
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
    }

    public function save()
    {
        $user = Auth::user();

        $validated = $this->validate([
            'type' => ['required', 'string'],
            'label' => ['nullable', 'string', 'max:255'],
            'line1' => ['required', 'string', 'max:255'],
            'line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        if($this->is_default) {
            $user->addresses()->where('type',$this->type)->where('is_default',true)->update(['is_default' => false]);
        }

        $user->addresses()->create([
            'type'      => $this->type,
            'label'     => $this->label,
            'line1'     => $this->line1,
            'line2'     => $this->line2,
            'city'      => $this->city,
            'state'     => $this->state,
            'postal_code'   => $this->postal_code,
            'country'   => $this->country,
            'is_default'    => $this->is_default,
        ]);

        $this->dispatch('created');
        
        $this->resetExcept('states');

        $this->toast()->success('Address added successfully!')->send();
    }

    public function render(): View
    {
        return view('livewire.user.create-address');
    }
}
