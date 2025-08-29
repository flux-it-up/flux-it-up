<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Livewire\Traits\GeneratesSku;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasRoles, GeneratesSku;

    protected $fillable = [
        'name', 
        'code',
        'description', 
        'category_id', 
        'price',
        'cost', 
        'quantity',
        'min_quantity',
        'weight',
        'dimensions',
        'warranty',
        'sku',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'cost' => 'decimal:2',
        ];
    }

    protected  $appends = ['primary_image'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            $product->sku = $product->generatesProductSku();
        });
    }

    public function getPrimaryImageAttribute()
    {
        $primaryImage = $this->images->firstWhere('is_primary', true);

        return $primaryImage ? $primaryImage->image_url : 'products/placeholder.png';
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function consoles()
    {
        return $this->belongsToMany(Console::class, 'product_console');
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
