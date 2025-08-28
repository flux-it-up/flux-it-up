<?php

namespace App\Livewire\Service;

use App\Livewire\Traits\Alert;
use App\Models\Service;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Delete extends Component
{
    use Alert;

    public Service $service;

    public function render()
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
        $this->service->delete();

        $this->dispatch('deleted');

        $this->toast()->success('Service removed successfully!')->send();
    }
}
