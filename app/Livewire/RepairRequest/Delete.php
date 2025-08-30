<?php

namespace App\Livewire\RepairRequest;

use App\Livewire\Traits\Alert;
use App\Models\RepairRequest;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Delete extends Component
{
    use Alert;

    public RepairRequest $repair;

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
        $order = $this->repair->order;

        $this->repair->delete();

        if($order) {
            $order->delete();
        }

        $this->dispatch('deleted');

        $this->toast()->success('Repair request removed successfully!')->send();
    }
}
