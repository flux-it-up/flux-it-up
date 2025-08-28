<?php

namespace App\Livewire\PricingTier;

use App\Livewire\Traits\Alert;
use App\Models\Service;
use App\Models\PricingTier;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use Alert;

    public PricingTier $pricing_tier;

    public $selectedServices;
    public $service_ids = [];

    public bool $modal = false;

    public function mount(): void 
    {
        $this->pricing_tier = new PricingTier();
        $this->selectedServices = Service::all();
    }

    public function render()
    {
        return view('livewire.pricing-tier.create');
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

        $this->dispatch('created');

        $this->resetExcept('selectedServices');
        $this->pricing_tier = new PricingTier();

        $this->toast()->success('Pricing Tier created successfully!')->send();
    }
}
