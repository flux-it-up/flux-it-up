<?php

namespace App\Livewire\Frontend\Products;

use Livewire\Component;
use App\Models\Product;

class ProductPage extends Component
{
    public Product $product;

    public function render()
    {
        return view('livewire.frontend.products.product-page')->layout('layouts.site');
    }
}
