<?php

namespace App\Livewire\Admin\Console;

use App\Livewire\Traits\Alert;
use App\Models\Console;
use App\Models\ConsoleBrand;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use Alert, WithFileUploads;

    public Console $console;
    public $brands;
    public $image, $newImage, $years;
    public $specifications = [];

    public bool $modal = false;

    public function mount(): void
    {
        $this->console = new Console();
        $this->brands = ConsoleBrand::all();
        $this->image = $this->console->image;
        $this->specifications = [['name'=>null,'svalue'=>null]];
    }

    public function render()
    {
        return view('livewire.admin.console.create');
    }

    public function rules(): array
    {
        return [
            'console.brand_id' => [
                'required',
                'integer',
                'max:255'
            ],
            'console.model' => [
                'required',
                'string',
                'max:255'
            ],
            'console.model_number' => [
                'required',
                'string',
                'max:255'
            ],
            'console.release_year' => [
                'required',
                'integer',
                'digits:4'
            ],
            'newImage' => [
                'nullable',
                'image',
                'max:2048' // 2MB
            ],
            'specifications.*.name' => ['required_with:specifications.*.svalue|string|max:255'],
            'specifications.*.svalue' => ['required_with:specifications.*.name|string|max:255'],
        ];
    }

    public function addSpecificationsRow()
    {
        $this->specifications[] = ['name' => '', 'svalue' => ''];
    }

    public function removeSpecificationsRow($index)
    {
        if (count($this->specifications) >= 1) {
            unset($this->specifications[$index]);
            $this->specifications = array_values($this->specifications);
        }
        if (count($this->specifications) == 0) {
            $this->specifications[] = ['name' => '', 'svalue' => ''];
        }
    }

    private function cleanSpecifications()
    {
        $this->specifications = collect($this->specifications)
            ->map(function ($spec) {
                return [
                    'name' => isset($spec['name']) ? (string) $spec['name'] : '',
                    'svalue' => isset($spec['svalue']) ? (string) $spec['svalue'] : '',
                ];
            })
            ->values()
            ->toArray();
    }

    private function transformSpecifications()
    {
        return collect($this->specifications)
            ->filter(function ($spec) {
                return !empty($spec['name']) && !empty($spec['svalue']);
            })
            ->mapWithKeys(function ($spec) {
                $value = $spec['svalue'];
                
                // Convert string representations to proper types
                if ($value === 'true') $value = true;
                elseif ($value === 'false') $value = false;
                elseif (is_numeric($value)) {
                    $value = str_contains($value, '.') ? (float)$value : (int)$value;
                }
                
                return [$spec['name'] => $value];
            })
            ->toArray();
    }

    public function save(): void 
    {
        $this->cleanSpecifications();

        $this->validate();

        $transformedSpecs = $this->transformSpecifications();

        $this->console->specifications = $transformedSpecs;

        if($this->newImage) {
            if($this->image)
            {
                Storage::disk('public')->delete($this->image);
            }
            
            $path = $this->newImage->store('consoles/'.strtolower($this->console->brand),'public');
            $this->console->image = $path;
        }

        $this->console->save();

        $this->dispatch('created');

        $this->resetExcept('years');
        $this->console = new Console();

        $this->toast()->success('Console created successfully!')->send();
    }
}
