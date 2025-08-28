<?php

namespace App\Livewire\User;

use App\Livewire\Traits\Alert;
use App\Models\Address;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateAddress extends Component
{
    use Alert;

    public ?Address $address;

    public $states;

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

    public function render(): View
    {
        return view('livewire.user.update-address');
    }

    #[On('load::address')]
    public function load(Address $address): void
    {
        $this->address = $address;

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'address.type' => [
                'required',
                'string'
            ],
            'address.label' => [
                'nullable', 
                'string', 
                'max:255'
            ],
            'address.line1' => [
                'required', 
                'string', 
                'max:255'
            ],
            'address.line2' => [
                'nullable', 
                'string', 
                'max:255'
            ],
            'address.city' => [
                'required', 
                'string', 
                'max:255'
            ],
            'address.state' => [
                'required', 
                'string', 
                'max:255'
            ],
            'address.postal_code' => [
                'required', 
                'string', 
                'max:255'
            ],
            'address.country' => [
                'required', 
                'string', 
                'max:255'
            ],
            'address.is_default' => [
                'nullable', 
                'boolean'
            ],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->address->save();

        $this->dispatch('updated');

        $this->resetExcept('user','states');

        $this->success();
    }
}
