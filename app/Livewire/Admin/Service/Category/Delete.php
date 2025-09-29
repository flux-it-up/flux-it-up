<?php

namespace App\Livewire\Admin\Service\Category;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\ServiceCategory;
use Livewire\Attributes\Renderless;

class Delete extends Component
{
    use Alert;

    public ServiceCategory $category;

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
        $this->category->delete();

        $this->dispatch('deleted');

        $this->toast()->success('Service Category removed successfully!')->send();
    }
}
