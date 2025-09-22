<?php

namespace App\Livewire\Admin\Service;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Service;

class View extends Component
{
    public ?Service $service = null;
    public bool $modal = false;

    #[On('view::service')]
    public function load($id)
    {
        $this->service = Service::with('category','consoles')->find($id);
        $this->modal = true;
    }   



    public function render()
    {
        return view('livewire.admin.service.view');
    }
}
