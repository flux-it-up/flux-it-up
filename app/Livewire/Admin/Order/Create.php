<?php

namespace App\Livewire\Admin\Order;

use Livewire\Component;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\OrderService;

class Create extends Component
{
    use Alert;

    public Order $order;
    public $users, $allProducts;
    public $products = [];

    public bool $modal = false;

    public function mount(): void
    {
        $this->order = new Order();
        $this->order->order_type = 'product';
        $this->users = User::all();
        $this->allProducts = Product::select('id','name')->get();
        $this->products = [['id'=>null,'quantity'=>1]];
        $this->order->order_status = 'pending';
        $this->order->payment_status = 'pending';
        $this->order->is_gift = false;

    }

    public function rules(): array
    {
        return [
            'order.user_id' => ['required','integer'],
            'order.order_type' => ['required', 'string'],
            'order.order_status' => ['required','string'],
            'order.payment_status' => ['required','string'],
            'order.currency' => ['required','string'],
            'order.notes' => ['nullable','string'],
            'products' => ['required','array','min:1'],
            'products.*.id' => ['required','exists:products,id'],
            'products.*.quantity' => ['required','integer','min:1'],
            'order.discount_code' => ['nullable','string','max:100'],
            'order.admin_notes' => ['nullable','string'],
            'order.is_gift' => ['required','boolean'],
            'order.gift_message' => ['nullable','string'],
        ];
    }

    public function addProductRow()
    {
        $this->products[] = ['id' => null, 'quantity' => 1];
    }

    public function removeProductRow($index)
    {
        if (count($this->products) >= 1) {
            unset($this->products[$index]);
            $this->products = array_values($this->products);
        }
        if (count($this->products) == 0) {
            $this->products[] = ['id' => null, 'quantity' => 1];
        }
    }

    public function save()
    {
        $this->validate();

        app(OrderService::class)->createOrder($this->order,$this->products);

        $this->dispatch('created');

        $this->reset('products');
        $this->order = new Order();
        $this->modal = false;

        $this->toast()->success('Order created successfully!');
    }

    public function render()
    {
        return view('livewire.admin.order.create');
    }
}
