<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\Navigation\NavigationItem;
use App\Navigation\MainNavigation;

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
        $this->crumbs[] = ['title' => 'Products', 'url' => route('products.index')];

        $route = request()->route();

        if ($route && $route->parameter('category')) {
            $categorySlug = $route->parameter('category');
            $category = ProductCategory::where('slug', $categorySlug)->first();

            if ($category) {
                $this->crumbs[] = [
                    'title' => $category->name,
                    'url' => route('products.category', $category->slug)
                ];

                if ($route->parameter('product')) {
                    $productSlug = $route->parameter('product');
                    $product = Product::where('slug', $productSlug)->first();

                    if ($product) {
                        $this->crumbs[] = [
                            'title' => $product->name,
                            'url' => null
                        ];
                    }
                }
            }
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
