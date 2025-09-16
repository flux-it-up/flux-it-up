<?php

namespace App\Livewire\Admin\Product;

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
    public $inventory = [];
    public $productCategories;
    public $consoles;

    public $selectedConsoles = [];
    public $console_ids = [];
    public $specifications = [];

    public bool $modal = false;

    public function mount(): void
    {
        $this->productCategories = ProductCategory::select('name','id')->get();
        $this->consoles = Console::select('name','id')->get();
    }

    public function rules(): array
    {
        $rules = [
            'product.name' => ['required','string','max:255'],
            'product.description' => ['required','string'],
            'product.category_id' => ['required','integer'],
            'product.price_override' => ['nullable','decimal:2'],
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
            'product.cost_markup' => ['required','decimal:2'],
        ];

        // Handle sale validation conditionally
        if ($this->product['on_sale'] ?? false) {
            // When on sale, require either sale_percent OR sale_price_override (but not both required)
            $rules['product.sale_percent'] = [
                'nullable',
                'decimal:2',
                'max:100.00',
                function ($attribute, $value, $fail) {
                    $saleOverride = $this->product['sale_price_override'] ?? null;
                    if (empty($value) && empty($saleOverride)) {
                        $fail('Either sale percentage or sale price override is required when product is on sale.');
                    }
                    if ($value > 100) {
                        $fail('Sale percentage cannot be more than 100%.');
                    }
                }
            ];
            
            $rules['product.sale_price_override'] = [
                'nullable',
                'decimal:2',
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
            $rules['product.sale_percent'] = ['nullable','decimal:2'];
            $rules['product.sale_price_override'] = ['nullable','decimal:2'];
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
        $priceOverride = $this->product['price_override'] ?? null;
        $cost = (float) ($this->product['cost'] ?? 0);
        $costMarkup = (float) ($this->product['cost_markup'] ?? 0);

        // Handle price override
        if ($priceOverride !== null && $priceOverride !== '' && is_numeric($priceOverride) && $priceOverride > 0) {
            return (float) $priceOverride;
        } 
        // Handle cost markup
        elseif ($costMarkup > 0) {
            return $cost + ($cost * ($costMarkup / 100));
        } 
        // Default to cost
        else {
            return $cost;
        }
    }

    public function updated($propertyName)
    {
        // Handle decimal field updates in real-time
        $this->handleDecimalFieldUpdate($propertyName);
    }

    public function updatedProductPriceOverride($value)
    {
        // Clean the value first
        if ($value === '' || $value === null) {
            $this->product['price_override'] = null;
        } elseif (!is_numeric($value)) {
            $this->product['price_override'] = null;
        }
        
        $this->validateSalePricing();
    }

    public function updatedProductSalePriceOverride($value)
    {
        // Clean the value first
        if ($value === '' || $value === null) {
            $this->product['sale_price_override'] = null;
        } elseif (!is_numeric($value)) {
            $this->product['sale_price_override'] = null;
        } elseif ($value && $value >= $this->getCalculatedPrice()) {
            $this->addError('product.sale_price_override', 'Sale price override must be less than regular price (' . Number::format($this->getCalculatedPrice(), precision: 2) . ').');
        }
    }

    public function updatedProductSalePercent($value)
    {
        // Clean the value first
        if ($value === '' || $value === null) {
            $this->product['sale_percent'] = null;
            return;
        } elseif (!is_numeric($value)) {
            $this->product['sale_percent'] = null;
            return;
        }

        if ($value && $value > 100) {
            $this->addError('product.sale_percent', 'Sale percentage cannot be more than 100%.');
            return;
        }

        if ($value) {
            $regularPrice = $this->getCalculatedPrice();
            $salePrice = $regularPrice - ($regularPrice * ($value / 100));
            
            if ($salePrice > $regularPrice) {
                $this->addError('product.sale_percent', 'Sale percentage results in a price higher than regular price.');
            }
        }
    }

    public function updatedProductCost($value)
    {
        // Clean the value first
        if ($value === '' || $value === null) {
            $this->product['cost'] = 0;
        } elseif (!is_numeric($value)) {
            $this->product['cost'] = 0;
        }
        
        $this->validateSalePricing();
    }

    public function updatedProductCostMarkup($value)
    {
        // Clean the value first
        if ($value === '' || $value === null) {
            $this->product['cost_markup'] = 0;
        } elseif (!is_numeric($value)) {
            $this->product['cost_markup'] = 0;
        }
        
        $this->validateSalePricing();
    }

    public function updatedProductWeight($value)
    {
        // Clean the value first
        if ($value === '' || $value === null) {
            $this->product['weight'] = null;
        } elseif (!is_numeric($value)) {
            $this->product['weight'] = null;
        }
    }

    private function validateSalePricing()
    {
        // Re-validate sale pricing when base price components change
        if ($this->product['sale_price_override'] ?? null) {
            $this->updatedProductSalePriceOverride($this->product['sale_price_override']);
        }
        
        if ($this->product['sale_percent'] ?? null) {
            $this->updatedProductSalePercent($this->product['sale_percent']);
        }
    }

    #[On('load::product')]
    public function load($id): void
    {
        $this->product = Product::with('consoles','inventory')->findOrFail($id);

        $this->inventory = $this->product->inventory;

        $this->selectedConsoles = $this->product->consoles->pluck('id')->toArray();

        $this->loadSpecifications($this->product->specifications);

        $this->modal = true;
    }

    public function render()
    {
        return view('livewire.admin.product.update');
    }

    public function loadSpecifications($specificationsJson)
    {
        $this->specifications = [];
        if ($specificationsJson && is_array($specificationsJson)) {
            foreach ($specificationsJson as $name => $value) {
                $this->specifications[] = [
                    'name' => $name,
                    'svalue' => $value
                ];
            }
        }
        
        // Always have at least one empty row
        if (empty($this->specifications)) {
            $this->specifications[] = ['name' => '', 'svalue' => ''];
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

    private function handleDecimalFieldUpdate($propertyName)
    {
        $decimalFields = [
            'product.price_override' => 'nullable',
            'product.sale_price_override' => 'nullable', 
            'product.sale_percent' => 'nullable',
            'product.cost' => 'required',
            'product.cost_markup' => 'required',
            'product.weight' => 'nullable',
        ];

        if (array_key_exists($propertyName, $decimalFields)) {
            $value = data_get($this, $propertyName);
            $isRequired = $decimalFields[$propertyName] === 'required';
            
            if ($value === '' || $value === null) {
                data_set($this, $propertyName, $isRequired ? 0 : null);
            } elseif (!is_numeric($value)) {
                data_set($this, $propertyName, $isRequired ? 0 : null);
            } else {
                data_set($this, $propertyName, (float) $value);
            }
        }
    }

    private function cleanAllDecimalFields()
    {
        $decimalFields = [
            'product.price_override' => 'nullable',
            'product.sale_price_override' => 'nullable', 
            'product.sale_percent' => 'nullable',
            'product.cost' => 'required',
            'product.cost_markup' => 'required',
            'product.weight' => 'nullable',
        ];

        foreach ($decimalFields as $field => $type) {
            $value = data_get($this, $field);
            $isRequired = $type === 'required';
            
            if ($value === '' || $value === null) {
                data_set($this, $field, $isRequired ? 0 : null);
            } elseif (!is_numeric($value)) {
                data_set($this, $field, $isRequired ? 0 : null);
            } else {
                data_set($this, $field, (float) $value);
            }
        }
    }

    public function save(): void 
    {
        $this->cleanSpecifications();
        $this->cleanAllDecimalFields();

        $this->validate();

        $transformedSpecs = $this->transformSpecifications();

        $this->product->specifications = $transformedSpecs;

        $this->product->save();

        $this->product->consoles()->sync($this->selectedConsoles);

        $this->modal = false;

        $this->dispatch('updated');

        $this->resetExcept('product', 'productCategories', 'consoles','selectedConsoles');

        $this->toast()->success('Product updated successfully!')->send();
    }
}
