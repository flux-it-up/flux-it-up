<?php

namespace App\Livewire\Admin\Brand;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\ConsoleBrand;
use Livewire\Attributes\Renderless;

class Delete extends Component
{
    use Alert;

    public ConsoleBrand $brand;

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
        $this->brand->delete();

        $this->dispatch('deleted');

        $this->toast()->success('Console Brand removed successfully!')->send();
    }
}
