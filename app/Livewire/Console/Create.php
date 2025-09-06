<?php

namespace App\Livewire\Console;

use App\Livewire\Traits\Alert;
use App\Models\Console;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use Alert, WithFileUploads;

    public Console $console;
    public $image, $newImage, $years;

    public bool $modal = false;

    public function mount(): void
    {
        $this->console = new Console();
        $this->image = $this->console->image;
        $this->years = range(date('Y'),1970);
    }

    public function render()
    {
        return view('livewire.console.create');
    }

    public function rules(): array
    {
        return [
            'console.brand' => [
                'required',
                'string',
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

        $this->dispatch('created');

        $this->resetExcept('years');
        $this->console = new Console();

        $this->toast()->success('Console created successfully!')->send();
    }
}
