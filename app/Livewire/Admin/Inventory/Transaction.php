<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use App\Models\InventoryTransaction;

class Transaction extends Component
{
    use Alert;

    public $transactions;
    public string $product;

    public bool $modal = false;

    public function render()
    {
        return view('livewire.admin.inventory.transaction');
    }

    #[On('load::transactions')]
    public function load($id, $product)
    {
        $this->transactions = InventoryTransaction::with('product','user')->where('product_id',$id)->limit(5)->latest()->get();
        $this->product = $product;

        $this->modal = true;
    }
}
