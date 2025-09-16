<?php

namespace App\Livewire\Traits;
use Illuminate\Support\Str;
use App\Models\Product;

trait ProductCode
{
    public static function setProductCode(Product $product)
    {
        $code = Str::of($product->name)
            ->explode(' ')
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');

        return $code;
    }
}
