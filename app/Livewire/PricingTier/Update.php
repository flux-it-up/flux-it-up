<?php

namespace App\Livewire\PricingTier;

use App\Livewire\Traits\Alert;
use App\Models\Service;
use App\Models\PricingTier;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use Alert;
    
    public ?PricingTier $pricing_tier;

    public $selectedServices;
    public $service_ids = [];

    public bool $modal = false;

    public function __construct()
    {
        $this->selectedServices = Service::all();
    }

    public function render()
    {
        return view('livewire.pricing-tier.update');
    }

    #[On('load::pricing-tier')]
    public function load(PricingTier $pricing_tier): void
    {
        $this->pricing_tier = $pricing_tier;
        $this->service_ids = $pricing_tier->services()->pluck('id')->toArray();
        $this->selectedServices = Service::all();

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'pricing_tier.name' => [
                'required',
                'string',
                'max:255'
            ],
            'pricing_tier.price' => [
                'required',
                'decimal:2'
            ],
            'pricing_tier.warranty' => [
                'required',
                'string',
                'max:255'
            ],
            'pricing_tier.estimated_time' => [
                'required',
                'string',
                'max:255'
            ]
        ];
    }

    public function save(): void 
    {
        $this->validate();

        $this->pricing_tier->save();

        $this->pricing_tier->services()->sync($this->service_ids);

        $this->dispatch('updated');

        $this->resetExcept('pricing_tier','selectedServices');

        $this->toast()->success('Pricing Tier created successfully!')->send();
    }
}
