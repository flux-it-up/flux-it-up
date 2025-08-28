<?php

namespace App\Livewire\Console;

use App\Livewire\Traits\Alert;
use App\Models\Console;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use Alert;

    public ?Console $console;
    
    public bool $modal = false;
    
    public function render()
    {
        return view('livewire.console.update');
    }

    #[On('load::console')]
    public function load(Console $console): void
    {
        $this->console = $console;

        $this->modal = true;
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

        $this->dispatch('updated');

        $this->resetExcept('console');

        $this->toast()->success('Console updated successfully!')->send();
    }
}
