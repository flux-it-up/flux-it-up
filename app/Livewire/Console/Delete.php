<?php

namespace App\Livewire\Console;

use App\Livewire\Traits\Alert;
use App\Models\Console;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Delete extends Component
{
    use Alert;

    public Console $console;

    public function render(): string
    {
        return <<<'HTML'
        <div>
            <x-button.circle icon="trash" color="red" wire:click="confirm" />
        </div>
        HTML;
    }

    #[Renderless]
    public function confirm(): void
    {
        $this->question()
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        $this->console->delete();

        $this->dispatch('deleted');

        $this->toast()->success('Console removed successfully!')->send();
    }
}
