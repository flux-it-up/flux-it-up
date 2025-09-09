<?php

namespace App\Livewire\Admin\Users;

use App\Livewire\Traits\Alert;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;
use Spatie\Permission\Models\Role;

class AssignUsers extends Component
{
    use Alert, Interactions;

    public ?User $user;

    public $roles;

    public $selectedRoles = [];

    public bool $modal = false;

    public function mount()
    {
        $this->roles = Role::pluck('name')->map(fn($r) => [
            'label' => ucwords(str_replace('-', ' ', $r)),
            'value' => $r,
        ])->toArray();
    }

    #[On('assign::user')]
    public function assign(User $user): void
    {
        $this->user = $user;

        $this->modal = true;
    }

    public function render()
    {
        return view('livewire.admin.users.assign-users');
    }

    public function save(): void
    {
        $this->user->syncRoles($this->selectedRoles);

        $this->dispatch('assigned');

        $this->modal = false;

        $this->reset('selectedRoles');

        $this->toast()->success('User updated successfully!')->send();
    }
}
