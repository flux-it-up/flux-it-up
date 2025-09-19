<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Livewire\Traits\GeneratesSku;
use Illuminate\Support\Str;
use App\Livewire\Traits\ProductCode;
use Illuminate\Support\Number;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasRoles, GeneratesSku;

    protected $fillable = [
        'name', 
        'code',
        'description', 
        'category_id', 
        'price_override',
        'sale_price_override',
        'cost', 
        'sku',
        'is_featured',
        'specifications',
        'weight',
        'weight_unit',
        'length',
        'width',
        'height',
        'dimension_unit',
        'warranty',
        'slug',
        'on_sale',
        'sale_percent',
        'cost_markup',
    ];

    protected function casts(): array
    {
        return [
            'price_override' => 'decimal:2',
            'sale_price_override' => 'decimal:2',
            'cost' => 'decimal:2',
            'specifications' => 'array',
            'on_sale' => 'boolean',
            'sale_percent' => 'decimal:2',
            'cost_markup' => 'decimal:2',
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
        ];
    }

    protected  $appends = ['primary_image'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            $product->code = ProductCode::setProductCode($product);
            $product->sku = $product->generatesProductSku();
            $product->slug = Str::slug($product->name, '-');
        });

        static::created(function($product) {
            $product->inventory()->create([
                'quantity' => 0,
                'min_quantity' => 1,
                'site_location' => 'main warehouse',
                'last_restock_date' => now(),
            ]); 
        });
    }

    public function getPriceAttribute()
    {
        if($this->price_override && $this->price_override >= 0.00) {
            return Number::format($this->price_override,precision:2);
        } elseif($this->cost_markup > 0.00) {
            return Number::format($this->cost + ($this->cost * ($this->cost_markup / 100)),precision:2);
        } else {
            return $this->cost;
        }
    }

    public function getSalePriceAttribute()
    {
        if($this->sale_price_override && $this->sale_price_override >= 0.00) {
            return Number::format($this->sale_price_override,precision:2);
        } elseif($this->sale_percent > 0.00 && $this->sale_percent <= 100) {
            return Number::format($this->price - ($this->price * ($this->sale_percent / 100)),precision:2);
        } else {
            return null;
        }
    }

    // In your Product model
    public function setPriceOverrideAttribute($value)
    {
        $this->attributes['price_override'] = ($value === '' || $value === null) ? null : $value;
    }

    public function setSalePriceOverrideAttribute($value)
    {
        $this->attributes['sale_price_override'] = ($value === '' || $value === null) ? null : $value;
    }

    public function setSalePercentAttribute($value)
    {
        $this->attributes['sale_percent'] = ($value === '' || $value === null) ? null : $value;
    }

    public function setWeightAttribute($value)
    {
        $this->attributes['weight'] = ($value === '' || $value === null) ? null : $value;
    }

    public function setCostAttribute($value)
    {
        $this->attributes['cost'] = ($value === '' || $value === null) ? 0 : $value;
    }

    public function setCostMarkupAttribute($value)
    {
        $this->attributes['cost_markup'] = ($value === '' || $value === null) ? 0 : $value;
    }

    public function getPrimaryImageAttribute()
    {
        $primaryImage = $this->images->firstWhere('is_primary', true);

        return $primaryImage ? $primaryImage->image_url : 'products/placeholder.png';
    }

    public function getQuantityAttribute()
    {
        return $this->inventory->quantity ?? 0;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function consoles()
    {
        return $this->belongsToMany(Console::class, 'product_console');
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }

    public function orderedImages()
    {
        return $this->images()->orderByDesc('is_primary')->orderBy('sort_order');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
            ->withPivot(['quantity']);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}
