<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\ServiceCategory;

class Home extends Component
{
    public $categories;

    public function mount(): void 
    {
        $this->categories = ServiceCategory::limit(4)->get();
    }

    public function render()
    {
        return view('livewire.frontend.home')->layout('layouts.site');
    }
}
