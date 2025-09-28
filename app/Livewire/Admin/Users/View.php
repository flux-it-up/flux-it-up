<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\User;

class View extends Component
{
    public ?User $user = null;
    public bool $modal = false;

    #[On('view::user')]
    public function load($id)
    {
        logger('load function hit');
        $this->user = User::findOrFail($id);
        $this->modal = true;
    }

    public function render()
    {
        return view('livewire.admin.users.view');
    }
}
