<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class OrderItem extends Model
{
    use HasRoles;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'options',
        'notes',
    ];

    protected function casts()
    {
        return [
            'item_price' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
