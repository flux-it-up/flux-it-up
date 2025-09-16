<?php

namespace App\Navigation;

use Spatie\Navigation\Navigation;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

class MainNavigation
{
    public static function build(): Navigation
    {
        $nav = Navigation::make()
            ->add('Home', route('welcome'))
            ->add('Products', route('products'), function ($products) {
                foreach (ProductCategory::all() as $category) {
                    $products->add(
                        $category->name,
                        route('products.category', $category->slug),
                        function ($section) use ($category) {
                            foreach ($category->products as $product) {
                                $section->add(
                                    $product->name,
                                    route('products.show', [
                                        'category' => $category->slug,
                                        'product'  => $product->slug,
                                    ])
                                );
                            }
                        }
                    );
                }
            });

        return $nav;
    }
}