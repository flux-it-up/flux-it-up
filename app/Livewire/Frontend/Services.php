<?php

namespace App\Livewire\Frontend;

use App\Models\ServiceCategory;
use App\Models\ConsoleBrand;
use Livewire\Component;

class Services extends Component
{
    public $brands;

    public function mount()
    {
        $this->brands = ConsoleBrand::with(['consoles.services'])->get();
    }

    public function render()
    {
        return view('livewire.frontend.services')->layout('layouts.site');
    }
}
