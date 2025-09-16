<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'product_id',
        'quantity',
        'min_quantity',
        'site_location',
        'shelf_location',
        'last_restock_date',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($inventory) {
            $inventory->last_restock_date = now();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}
