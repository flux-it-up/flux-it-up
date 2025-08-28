<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use App\Models\Address;

class DeleteAddress extends Component
{
    use Alert;

    public User $user;
    public Address $address;

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

    public function delete()
    {
        if ($this->address->is_default) {
            $this->error('You cannot delete a default shipping/billing address.','Delete Default');
            return;
        }

        $this->address->delete();

        $this->dispatch('deleted');
        
        $this->success();
    }
}
