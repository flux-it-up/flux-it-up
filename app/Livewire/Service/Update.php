<?php

namespace App\Livewire\Service;

use App\Livewire\Traits\Alert;
use App\Models\Service;
use App\Models\Console;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use Alert;
    
    public ?Service $service;
    public $consoles;

    public $selectedConsoles = [];
    public $console_ids = [];
    public $priceAdjustments = [];
    public $generatedSkus = [];

    public bool $modal = false;

    public function mount()
    {
        $this->consoles = Console::all();
    }

    public function render()
    {
        return view('livewire.service.update');
    }

    #[On('load::service')]
    public function load(Service $service): void
    {
        $this->service = $service;
        $this->selectedConsoles = $service->consoles->mapWithKeys(function ($console) {
            return [$console->id => ['selected' => true, 'price' => $console->pivot->price_adjustment]];
        })->toArray();

        foreach($this->selectedConsoles as $consoleId => $data) {
            $this->priceAdjustments[$consoleId] = [
                    'price_adjustment' => $data['price'] ?? null,
                ];
        }

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'service.name' => ['required', 'string', 'max:255'],
            'service.description' => ['required', 'string', 'max:255'],
            'service.code' => ['required', 'string', 'max:10'],
            'service.category' => ['required', 'string', 'max:255'],
            'service.base_price' => ['required', 'decimal:2'],
            'service.estimated_time' => ['required', 'string', 'max:255']
        ];
    }

    public function save(): void 
    {
        $syncData = [];

        foreach ($this->selectedConsoles as $consoleId => $data) {
            if (!empty($data['selected'])) {
                $syncData[$consoleId] = [
                    'price_adjustment' => $this->priceAdjustments[$consoleId]['price_adjustment'] ?? null,
                ];
            }
            if(empty($data['selected'])) {
                unset($this->selectedConsoles[$consoleId]);
            }
        }

        $this->validate();

        $this->service->save();

        $this->service->consoles()->sync($syncData);

        $this->generateSkus();

        $this->dispatch('updated');

        $this->resetExcept('service', 'consoles', 'priceAdjustments', 'selectedConsoles');

        $this->toast()->success('Service updated successfully!')->send();
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

            foreach ($this->selectedConsoles as $index => $consoleId) {
                $consoleData[] = [
                    'console_id' => $index,
                    'price_adjustment' => $this->priceAdjustments[$index]['price_adjustment'] ?? 0
                ];
            }

            $this->generatedSkus = $skuService->generateBulkServiceConsoleSku($this->service, $consoleData);
            
            $this->toast()->success('SKUs generated successfully!')->send();
        } catch (\Exception $e) {
            $this->toast()->error('Error generating SKUs: ' . $e->getMessage())->send();
        }
    }
}
