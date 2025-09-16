<?php

namespace App\Livewire\Admin\Order;

use App\Livewire\Traits\Alert;
use Livewire\Component;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use TallStackUi\Traits\Interactions;

class Update extends Component
{
    use Alert, Interactions;

    public ?Order $order;
    public $users, $allProducts, $subtotal, $total;
    public $products = [];

    public bool $modal = false;

    public function mount(): void
    {
        $this->users = User::all();
        $this->allProducts = Product::all();
    }

    #[On('load::order')]
    public function load(Order $order): void
    {
        $this->order = Order::with('items')->findOrFail($order->id);
        foreach($this->order->items as $item) {
            $this->products[] = ['id' => $item->product_id,'quantity' => $item->quantity];
        }

        $this->modal = true;
    }

    public function render()
    {
        return view('livewire.admin.order.update');
    }

    public function rules(): array
    {
        return [
            'order.user_id' => ['required','integer'],
            'order.order_type' => ['required', 'string'],
            'order.order_status' => ['required','string'],
            'order.payment_status' => ['required','string'],
            'order.subtotal' => ['required','decimal:2'],
            'order.total_amount' => ['required','decimal:2'],
            'order.currency' => ['required','string'],
            'order.notes' => ['nullable','string'],
            'products' => ['required','array','min:1'],
            'products.*.id' => ['required','exists:products,id'],
            'products.*.quantity' => ['required','integer','min:1'],
        ];
    }

    public function addProductRow()
    {
        $this->products[] = ['id' => null, 'quantity' => 1];
    }

    public function removeProductRow($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }

    public function save()
    {
        $this->validate();

        $this->order->save();

        $this->total = null;

        $this->order->items()->delete();

        foreach($this->products as $productData) {
            $product = Product::findOrFail($productData['id']);

            $this->order->items()->create([
                'order_id' => $this->order->id,
                'product_id' => $product->id,
                'quantity' => $productData['quantity'],
            ]);

            $this->total += $lineTotal;
        }

        $this->order->update(['total_amount' => $this->total]);

        $this->dispatch('updated');

        $this->resetExcept('order','users', 'allProducts');
        $this->order = new Order();

        $this->toast()->success('Order updated successfully!');
    }
}
