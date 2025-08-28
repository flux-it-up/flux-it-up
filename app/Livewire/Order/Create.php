<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;

class Create extends Component
{
    use Alert;

    public Order $order;
    public $users, $allProducts, $subtotal, $total;
    public $products = [];

    public bool $modal = false;

    public function mount(): void
    {
        $this->order = new Order();
        $this->users = User::all();
        $this->allProducts = Product::all();
        $this->products = [['id'=>null,'quantity'=>1]];
        $this->order->order_status = 'pending';
        $this->order->payment_status = 'pending';

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

    public function updatedProducts()
    {
        $this->calculateTotal();
    }

    public function removeProductRow($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->order->subtotal = 0;
        $this->order->total_amount = 0;

        foreach ($this->products as $productData) {
            if(!empty($productData['id'])) {
                $product = $this->allProducts->find($productData['id']);
                if($product) {
                    $this->order->subtotal += $product->price * $productData['quantity'];
                    $this->order->total_amount += $product->price * $productData['quantity'];
                }
            }
        }
    }

    public function save()
    {
        $this->validate();

        $this->order->save();

        $this->total = null;

        foreach($this->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $price = $product->price;
            $lineTotal = $price * $productData['quantity'];
            $total = 0;

            $this->order->items()->create([
                'order_id' => $this->order->id,
                'product_id' => $product->id,
                'quantity' => $productData['quantity'],
                'item_price' => $price,
                'total_price' => $lineTotal,
            ]);

            $total += $lineTotal;
        }

        $this->order->update(['total_amount' => $total]);

        $this->dispatch('created');

        $this->resetExcept('order','users', 'allProducts');
        $this->order = new Order();

        $this->toast()->success('Order created successfully!');
    }

    public function render()
    {
        return view('livewire.order.create');
    }
}
