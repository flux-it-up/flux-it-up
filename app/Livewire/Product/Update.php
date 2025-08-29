<?php

namespace App\Livewire\Product;

use App\Livewire\Traits\Alert;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Console;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Update extends Component
{
    use Alert, Interactions;

    public ?Product $product;
    public $productCategories;
    public $consoles;

    public $selectedConsoles = [];
    public $console_ids = [];

    public bool $modal = false;

    public function mount(): void
    {
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

    #[On('load::product')]
    public function load(Product $product): void
    {
        $this->product = $product;

        $this->selectedConsoles = $this->product->consoles->pluck('id')->toArray();

        $this->modal = true;
    }

    public function render()
    {
        return view('livewire.product.update');
    }

    public function save(): void 
    {
        $this->validate();

        $this->product->save();

        $this->product->consoles()->sync($this->selectedConsoles);

        $this->dispatch('updated');

        $this->resetExcept('product', 'productCategories', 'consoles','selectedConsoles',);

        $this->toast()->success('Product updated successfully!')->send();
    }
}
