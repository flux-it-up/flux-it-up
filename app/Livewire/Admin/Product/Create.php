<?php

namespace App\Livewire\Admin\Product;

use App\Livewire\Traits\Alert;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Console;
use App\Models\Inventory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use Alert;

    public Product $product;
    public $inventory = [];
    public $productCategories;
    public $specifications = [];
    public $consoles;

    public $selectedConsoles = [];
    public $console_ids = [];

    public bool $modal = false;

    public function mount(): void
    {
        $this->product = new Product();
        $this->productCategories = ProductCategory::select('name','id')->get();
        $this->consoles = Console::select('name','id')->get();
        $this->specifications = [['name'=>null,'svalue'=>null]];
        $this->product->on_sale = false;
        $this->product->sale_percent = 0.00;
        $this->product->cost_markup = 0.00;
    }

    public function rules(): array
    {
        $rules = [
            'product.name' => ['required','string','max:255'],
            'product.description' => ['required','string'],
            'product.category_id' => ['required','integer'],
            'product.price_override' => ['nullable','decimal:2','min:0.01'],
            'product.cost' => ['required','decimal:2','min:0.01'],
            'product.weight' => ['nullable','decimal:2'],
            'product.length' => ['nullable','integer'],
            'product.width' => ['nullable','integer'],
            'product.height' => ['nullable','integer'],
            'product.warranty' => ['required','string','max:100'],
            'product.weight_unit' => ['required_with:product.weight','string','max:100'],
            'product.dimension_unit' => ['required_with:product.length,product.width,product.height','string','max:100'],
            'specifications.*.name' => ['required_with:specifications.*.svalue|string|max:255'],
            'specifications.*.svalue' => ['required_with:specifications.*.name|string|max:255'],
            'product.on_sale' => ['required','boolean'],
            'product.cost_markup' => ['required','decimal:2','min:0',],
        ];

        // Handle sale validation conditionally
        if ($this->product['on_sale'] ?? false) {
            // When on sale, require either sale_percent OR sale_price_override (but not both required)
            $rules['product.sale_percent'] = [
                'nullable',
                'decimal:2',
                'min:0.01',
                'max:99.99', // Changed from 100.00 to 99.99
                function ($attribute, $value, $fail) {
                    $saleOverride = $this->product['sale_price_override'] ?? null;
                    if (empty($value) && empty($saleOverride)) {
                        $fail('Either sale percentage or sale price override is required when product is on sale.');
                    }
                    if ($value >= 100) {
                        $fail('Sale percentage cannot be 100% or more.');
                    }
                }
            ];
            
            $rules['product.sale_price_override'] = [
                'nullable',
                'decimal:2',
                'min:0.01',
                function ($attribute, $value, $fail) {
                    $salePercent = $this->product['sale_percent'] ?? null;
                    
                    // Require at least one sale method
                    if (empty($value) && empty($salePercent)) {
                        $fail('Either sale price override or sale percentage is required when product is on sale.');
                    }
                    
                    // Check if sale price is less than regular price
                    if ($value && $value >= $this->getCalculatedPrice()) {
                        $fail('Sale price must be less than regular price (' . number_format($this->getCalculatedPrice(), 2) . ').');
                    }
                }
            ];
        } else {
            // When not on sale, these fields are optional
            $rules['product.sale_percent'] = ['nullable','decimal:2','min:0','max:99.99'];
            $rules['product.sale_price_override'] = ['nullable','decimal:2','min:0'];
        }

        // Conditional validation for weight_unit
        if (!empty($this->product['weight'])) {
            $rules['product.weight_unit'] = ['required','string','max:100'];
        } else {
            $rules['product.weight_unit'] = ['nullable','string','max:100'];
        }

        // Conditional validation for dimension_unit
        $hasDimensions = !empty($this->product['length']) || 
                        !empty($this->product['width']) || 
                        !empty($this->product['height']);
        
        if ($hasDimensions) {
            $rules['product.dimension_unit'] = ['required','string','max:100'];
        } else {
            $rules['product.dimension_unit'] = ['nullable','string','max:100'];
        }

        return $rules;
    }

    public function getCalculatedPrice()
    {
        if ($this->product['price_override'] && $this->product['price_override'] >= 0.00) {
            return $this->product['price_override'];
        } elseif ($this->product['cost_markup'] > 0.00) {
            return $this->product['cost'] + ($this->product['cost'] * ($this->product['cost_markup'] / 100));
        } else {
            return $this->product['cost'];
        }
    }

    public function addSpecificationsRow()
    {
        $this->specifications[] = ['name' => '', 'svalue' => ''];
    }

    public function removeSpecificationsRow($index)
    {
        if (count($this->specifications) >= 1) {
            unset($this->specifications[$index]);
            $this->specifications = array_values($this->specifications);
        }
        if (count($this->specifications) == 0) {
            $this->specifications[] = ['name' => '', 'svalue' => ''];
        }
    }

    private function cleanSpecifications()
    {
        $this->specifications = collect($this->specifications)
            ->map(function ($spec) {
                return [
                    'name' => isset($spec['name']) ? (string) $spec['name'] : '',
                    'svalue' => isset($spec['svalue']) ? (string) $spec['svalue'] : '',
                ];
            })
            ->values()
            ->toArray();
    }

    private function transformSpecifications()
    {
        return collect($this->specifications)
            ->filter(function ($spec) {
                return !empty($spec['name']) && !empty($spec['svalue']);
            })
            ->mapWithKeys(function ($spec) {
                $value = $spec['svalue'];
                
                // Convert string representations to proper types
                if ($value === 'true') $value = true;
                elseif ($value === 'false') $value = false;
                elseif (is_numeric($value)) {
                    $value = str_contains($value, '.') ? (float)$value : (int)$value;
                }
                
                return [$spec['name'] => $value];
            })
            ->toArray();
    }

    public function save(): void 
    {
        $this->cleanSpecifications();

        $this->validate();

        $transformedSpecs = $this->transformSpecifications();

        $this->product->specifications = $transformedSpecs;

        $this->product->save();

        $this->product->consoles()->sync($this->selectedConsoles);

        $this->dispatch('created');

        $this->resetExcept('product','productCategories', 'consoles');
        $this->product = new Product();

        $this->toast()->success('Product created successfully!')->send();
    }

    public function render()
    {
        return view('livewire.admin.product.create');
    }
}
