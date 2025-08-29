<?php

namespace App\Livewire\Product;

use App\Livewire\Traits\Alert;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Console;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use Alert;

    public Product $product;
    public $productCategories;
    public $consoles;

    public $selectedConsoles = [];
    public $console_ids = [];

    public bool $modal = false;

    public function mount(): void
    {
        $this->product = new Product();
        $this->productCategories = ProductCategory::all();
        $this->consoles = Console::all();
    }

    public function rules(): array
    {
        return [
            'product.name' => ['required','string','max:255'],
            'product.description' => ['required','string'],
            'product.code' => ['required','string','max:255'],
            'product.category_id' => ['required','integer'],
            'product.price' => ['required','decimal:2'],
            'product.cost' => ['required','decimal:2'],
            'product.quantity' => ['required','integer'],
            'product.min_quantity' => ['required','integer'],
            'product.weight' => ['nullable','decimal:2'],
            'product.dimensions' => ['nullable','string','max:100'],
            'product.warranty' => ['required','string','max:100']
        ];
    }

    public function save(): void 
    {
        $this->validate();

        $this->product->save();

        $this->product->consoles()->sync($this->selectedConsoles);

        $this->dispatch('created');

        $this->resetExcept('product','productCategories', 'consoles','selectedConsoles',);
        $this->product = new Product();

        $this->toast()->success('Product created successfully!')->send();
    }

    public function render()
    {
        return view('livewire.product.create');
    }
}
