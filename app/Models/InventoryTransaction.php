<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity_change',
        'transaction_type',
        'reference_id',
        'notes',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
