<?php

namespace App\Livewire\Admin\Brand;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\ConsoleBrand;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Update extends Component
{
    use Alert, WithFileUploads;

    public ?ConsoleBrand $brand;
    public $image, $newImage;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.admin.brand.update');
    }

    #[On('load::brand')]
    public function load($id): void
    {
        $this->brand = ConsoleBrand::findOrFail($id);
        $this->image = $this->brand->logo;

        $this->modal = true;
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

        $this->dispatch('updated');

        $this->reset();

        $this->toast()->success('Console Brand updated successfully!')->send();
    }
}
