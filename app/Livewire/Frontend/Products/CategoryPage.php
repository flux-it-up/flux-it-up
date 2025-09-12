<?php

namespace App\Livewire\Frontend\Products;

use Livewire\Component;

class CategoryPage extends Component
{
    public function render()
    {
        return view('livewire.frontend.products.category-page')->layout('layouts.products');
    }
}
