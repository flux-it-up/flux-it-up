<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use App\Models\Inventory;
use App\Services\InventoryService;

class Update extends Component
{
    use Alert;

    public ?Inventory $inventory;
    public ?string $product;
    public int $quantity = 0;
    public string $notes;
    public string $transactionType = 'adjustment';

    public bool $modal = false;

    public function render()
    {
        return view('livewire.admin.inventory.update');
    }

    #[On('load::inventory')]
    public function load($id, $product)
    {
        $this->inventory = Inventory::with('product')->findOrFail($id);
        $this->product = $product;

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'quantity' => [
                'required','integer',
            ],
            'inventory.min_quantity' => [
                'nullable','integer',
            ],
            'notes' => [
                'required','string',
            ],
            'transactionType' => [
                'required','string',
            ],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->inventory->save();

        app(InventoryService::class)->recordTransaction(
            $this->inventory->product_id,
            $this->quantity,
            $this->inventory,
            $this->transactionType,
            $this->notes
        );

        $this->modal = false;

        $this->dispatch('updated');

        $this->reset('transactionType','notes','quantity');

        $this->toast()->success('Inventory updated successfully!')->send();
    }
}
