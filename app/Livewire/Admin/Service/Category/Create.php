<?php

namespace App\Livewire\Admin\Service\Category;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\ServiceCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;

class Create extends Component
{
    use Alert;

    public ServiceCategory $category;

    public bool $modal = false;

    public function mount(): void
    {
        $this->category = new ServiceCategory();
    }

    public function render()
    {
        return view('livewire.admin.service.category.create');
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
        $this->dispatch('created');

        $this->reset();
        $this->category = new ServiceCategory();

        $this->toast()->success('Service Category created successfully!')->send();
    }
}
