<?php

namespace App\Livewire\Admin\Brand;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\ConsoleBrand;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use Alert, WithFileUploads;

    public ConsoleBrand $brand;
    public $image, $newImage;

    public bool $modal = false;

    public function mount(): void
    {
        $this->brand = new ConsoleBrand();
        $this->image = $this->brand->image;
    }

    public function render()
    {
        return view('livewire.admin.brand.create');
    }

    public function rules(): array
    {
        return [
            'brand.name' => [
                'required',
                'string',
                'max:255'
            ],
            'newImage' => [
                'nullable',
                'image',
                'max:2048'
            ]
        ];
    }

    public function save(): void
    {
        $this->validate();

        if($this->newImage) {
            if($this->image) {
                Storage::disk('public')->delete($this->image);
            }

            $path = $this->newImage->store('consoles/'.strtolower($this->brand->name),'public');
            $this->brand->logo = $path;
        }

        $this->brand->save();

        $this->modal = false;

        $this->dispatch('created');

        $this->reset();
        $this->brand = new ConsoleBrand();

        $this->toast()->success('Console Brand created successfully!')->send();
    }
}
