<?php

namespace App\Livewire\Admin\Model;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use App\Models\ConsoleModel;
use Livewire\Attributes\Renderless;

class Delete extends Component
{
    use Alert;

    public ConsoleModel $model;

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
        $this->model->delete();

        $this->dispatch('deleted');

        $this->toast()->success('Console Model removed successfully!')->send();
    }
}
