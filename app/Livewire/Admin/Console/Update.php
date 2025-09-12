<?php

namespace App\Livewire\Admin\Console;

use App\Livewire\Traits\Alert;
use App\Models\Console;
use App\Models\ConsoleBrand;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Update extends Component
{
    use Alert, WithFileUploads;

    public ?Console $console;
    public $image, $newImage, $years;
    public $brands;
    
    public bool $modal = false;
    
    public function render()
    {
        return view('livewire.admin.console.update');
    }

    public function mount()
    {
        $this->years = range(date('Y'),1970);
        $this->brands = ConsoleBrand::all();
    }

    #[On('load::console')]
    public function load(Console $console): void
    {
        $this->console = $console;
        $this->image = $this->console->image;

        $this->modal = true;
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
            'console.specifications' => [
                'nullable',
                'json'
            ]
        ];
    }

    public function save(): void 
    {
        $this->validate();

        if($this->newImage) {
            if($this->image)
            {
                Storage::disk('public')->delete($this->image);
            }
            
            $path = $this->newImage->store('consoles/'.strtolower($this->console->brand),'public');
            $this->console->image = $path;
        }

        $this->console->save();

        $this->dispatch('updated');

        $this->resetExcept('console','years');

        $this->toast()->success('Console updated successfully!')->send();
    }
}
