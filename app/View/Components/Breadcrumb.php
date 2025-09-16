<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\Navigation\NavigationItem;
use App\Navigation\MainNavigation;
use App\Models\ProductCategory;
use App\Models\Product;

class Breadcrumb extends Component
{
    public array $crumbs = [];

    public function __construct()
    {
        $this->buildCrumbs();
    }

    private function buildCrumbs()
    {
        $this->crumbs[] = ['title' => 'Home', 'url' => route('welcome')];
        $this->crumbs[] = ['title' => 'Products', 'url' => route('products')];

        $route = request()->route();
        $categoryParam = $route->parameter('category');
        $productParam = $route->parameter('product');

        if ($route && $route->parameter('category')) {
            if (is_string($categoryParam)) {
                $category = ProductCategory::where('slug', $categoryParam)->first();
            } else {
                $category = $categoryParam;
            }
            if ($category) {
                if ($route->parameter('product')) {
                    $this->crumbs[] = [
                        'title' => $category->name,
                        'url' => route('products.category', $category->slug)
                    ];

                
                    if (is_string($productParam)) {
                        $product = Product::where('slug', $productParam)->first();
                    } else {
                        $product = $productParam;
                    }
                    if ($product) {
                        $this->crumbs[] = [
                            'title' => $product->name,
                            'url' => null
                        ];
                    }
                } else {
                    $this->crumbs[] = [
                        'title' => $category->name,
                        'url' => null
                    ];
                }
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
