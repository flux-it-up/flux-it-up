<?php

namespace App\Livewire\Admin\Service\Category;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\ServiceCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class Update extends Component
{
    use Alert;

    public ?ServiceCategory $category;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.admin.service.category.update');
    }

    #[On('load::category')]
    public function load($id): void
    {
        $this->category = ServiceCategory::findOrFail($id);

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'category.name' => [
                'required',
                'string',
                'max:255'
            ],
            'category.description' => [
                'required',
                'string',
                'max:255'
            ]
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->category->save();

        $this->modal = false;
        $this->dispatch('updated');

        $this->reset();

        $this->toast()->success('Service Category updated successfully!')->send();
    }
}
