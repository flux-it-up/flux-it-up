<?php

namespace App\Livewire\Customer\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use App\Models\{Address,User};
use App\Services\AddressService;

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
        $this->user = User::findOrFail($this->address->user_id);

        app(AddressService::class)->deleteAddress($this->user, $this->address);

        $this->dispatch('address-deleted');
        
        $this->toast()
                ->success('Address deleted successfully!')
                ->send();
    }
}
