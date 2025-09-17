<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'product_id',
        'transaction_type',
        'referenceable_type',
        'referenceable_id',
        'quantity_before',
        'quantity_after',
        'notes',
        'created_by',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function referenceable(): MorphTo
    {
        return $this->morphTo();
    }
}
