<?php

namespace App\Services;

use App\Models\Product;
use App\Models\InventoryTransaction;

class InventoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function recordTransaction($productId, $quantity, $reference, $type = null, $notes = null)
    {
        $product = Product::find($productId);
        $currentStock = $product->inventory->quantity;
        $newStock = $currentStock + $quantity;

        InventoryTransaction::create([
            'product_id' => $productId,
            'transaction_type' => $type,
            'referenceable_type' => get_class($reference),
            'referenceable_id' => $reference->id,
            'quantity_before' => $currentStock,
            'quantity_after' => $newStock,
            'notes' => $notes,
            'created_by' => auth()->id(),
            'created_at' => now(),
        ]);

        $product->inventory->update([
            'quantity' => $newStock,
        ]);
    }
}
