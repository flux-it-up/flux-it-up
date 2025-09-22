<?php

namespace App\Livewire\Admin\Console;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Console;

class View extends Component
{
    public ?Console $console = null;
    public bool $modal = false;

    #[On('view::console')]
    public function load($id)
    {
        $this->console = Console::with('models')->find($id);
        $this->modal = true;
    }

    public function render()
    {
        return view('livewire.admin.console.view');
    }
}
