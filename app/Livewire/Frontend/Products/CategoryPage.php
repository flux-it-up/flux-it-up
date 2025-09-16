<?php

namespace App\Livewire\Frontend\Products;

use Livewire\Component;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ConsoleBrand;

class CategoryPage extends Component
{
    public ProductCategory $category;

    // SEARCH/FILTERS/SORTING
    public ?string $search = null;
    public ?string $brand = null;
    public ?float $min_price = null;
    public ?float $max_price = null;
    public ?string $sort = null;

    // DROPDOWNS/CHECKBOXES
    public $categories;
    public $brands;

    public function mount()
    {
        $this->brands = ConsoleBrand::all()->unique();
    }

    public function render()
    {
        $query = Product::query()->with(['category','consoles'])->where('category_id',$this->category->id);

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        if ($this->brand) {
            $query->whereHas('consoles.brand', fn($q) => $q->where('brand_id', $this->brand));
        }

        if ($this->min_price !== null) {
            $query->whereRaw('COALESCE(sale_price, price) >=?', [number_format($this->min_price,2)]);
        }

        if ($this->max_price) {
            $query->whereRaw('COALESCE(sale_price, price) <=?', [number_format($this->max_price,2)]);
        }

        switch ($this->sort) {
            case 'latest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_asc':
                $query->orderByRaw('COALESCE(sale_price, price) asc');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(sale_price, price) desc');
                break;
            default:
                $query->orderBy('name', 'desc');
        }

        return view('livewire.frontend.products.category-page', [
            'category' => $this->category,
            'products' => $query->get(),
        ])->layout('layouts.site');
    }
}
