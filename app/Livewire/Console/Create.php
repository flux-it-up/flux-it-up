<?php

namespace App\Livewire\Console;

use App\Livewire\Traits\Alert;
use App\Models\Console;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use Alert;

    public Console $console;

    public bool $modal = false;

    public function mount(): void
    {
        $this->console = new Console();
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
            ]
        ];
    }

    public function save(): void 
    {
        $this->validate();

        $this->console->save();

        $this->dispatch('created');

        $this->reset();
        $this->console = new Console();

        $this->toast()->success('Console created successfully!')->send();
    }
}
