<?php

namespace App\Livewire\Service;

use App\Livewire\Traits\Alert;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Console;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Alert, Interactions;

    public Service $service;
    public $serviceCategories;
    public $consoles;

    public $selectedConsoles = [];
    public $console_ids = [];
    public $priceAdjustments = [];
    public $generatedSkus = [];

    public bool $modal = false;

    public function mount(): void 
    {
        $this->service = new Service();
        $this->consoles = Console::all();
        $this->serviceCategories = ServiceCategory::all();
        foreach($this->consoles as $console) {
            $this->priceAdjustments[$console->id] = $console->pivot->price_adjustment ?? 0;
        }
    }

    public function render()
    {
        return view('livewire.service.create');
    }

    public function rules(): array
    {
        return [
            'service.name' => ['required', 'string', 'max:255'],
            'service.description' => ['required', 'string', 'max:255'],
            'service.code' => ['required', 'string', 'max:10'],
            'service.category_id' => ['required', 'integer'],
            'service.base_price' => ['required', 'decimal:2'],
            'service.estimated_time' => ['required', 'string', 'max:255']
        ];
    }

    public function save(): void 
    {
        $this->validate();

        $this->service->save();

        $this->service->consoles()->sync($this->selectedConsoles);

        $this->generateSkus();

        $this->dispatch('created');

        $this->resetExcept('consoles','selectedConsoles','priceAdjustments', 'serviceCategories');
        $this->service = new Service();

        $this->toast()->success('Service created successfully!')->send();
    }

    public function generateSkus()
    {
        if (!$this->service) {
            $this->toast()->error('Please save the service first')->send();
            return;
        }

        if (empty($this->selectedConsoles)) {
            $this->toast()->error('Please select at least one console')->send();
            return;
        }

        try {
            $skuService = new SkuService();
            $consoleData = [];

            foreach ($this->selectedConsoles as $consoleId) {
                $consoleData[] = [
                    'console_id' => $consoleId,
                    'price_adjustment' => $this->priceAdjustments[$consoleId] ?? 0
                ];
            }

            $this->generatedSkus = $skuService->generateBulkServiceConsoleSku($this->service, $consoleData);
            
            $this->toast()->success('SKUs generated successfully!')->send();
        } catch (\Exception $e) {
            $this->toast()->error('Error generating SKUs: ' . $e->getMessage())->send();
        }
    }
}
