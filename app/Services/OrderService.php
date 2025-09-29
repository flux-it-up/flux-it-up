<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;
use App\Services\UserService;
use Illuminate\Support\Str;

class OrderService
{
    protected $state_tax_rate = 0;
    protected $county_tax_rate = 0;
    protected $city_tax_rate = 0;
    protected $user;
    public $order;
    
    public function __construct($userId, $order)
    {
        $this->user = User::with('defaultShippingAddress','defaultBillingAddress')->findOrFail($userId);
        $this->order = $order;
    }

    public function createAdminProductOrder($products = null)
    {
        //Prepare order data
        $this->order->order_number = 'ORD-PROD-'.now()->format('Ymd').'-'.Str::uuid();
        $this->order->shipping_address_id = $this->user->defaultShippingAddress->id;
        $this->order->billing_address_id = $this->user->defaultBillingAddress->id;
        $this->order->subtotal = $this->calculateProductSubtotal($products);
        $this->order->tax_amount = $this->calculateTaxes();
        $this->order->shipping_amount = $this->calculateShipping();
        if($this->order->discount_code){
            $this->order->discount_amount = $this->verifyDiscountCode();
        }
        dd($this->order);
        $this->order->paid_amount = $this->getPayments();
        $this->order->total_amount = $this->calculateTotal();
        $this->order->save();

        $pivotData = [];
        foreach($products as $product) {
            $pivotData[$product['id']] = ['quantity'=>$product['quantity']];
        }
        $this->order->products()->sync($pivotData);
    }

    public function createAdminRepairOrder($services = null)
    {

    }

    public function calculateProductSubtotal($products = null)
    {
        $subtotal = 0;

        foreach($products as $productData) {
            $product = Product::findOrFail($productData['id']);
            if($product->on_sale) {
                $subtotal += ($product->sale_price * $productData['quantity']);
            } else {
                $subtotal += ($product->price * $productData['quantity']);
            }
        }

        return $subtotal;
    }

    public function calculateTaxes()
    {
        $userService = new UserService($this->order->user_id);
        $state_tax_rate = $userService->getUserStateTax();
        $county_tax_rate = $userService->getUserCountyTax();
        $city_tax_rate = $userService->getUserCityTax();
        $total_tax_rate = $state_tax_rate + $county_tax_rate + $city_tax_rate;
        $total_tax = $this->order->subtotal * ($total_tax_rate/100);
        
        return $total_tax;
    }

    public function calculateShipping()
    {
        // Return 0 for now
        return 0.00;
    }

    public function verifyDiscountCode()
    {
        // Return 0 for now
        return 0.00;
    }

    public function getPayments()
    {
        $userService = new UserService($this->order->user_id);
        // Get Users Total Payments

        // Return 0 for now
        return 0.00;
    }

    public function calculateTotal()
    {
        $subtotal = $this->order->subtotal;
        $taxes = $this->order->tax_amount;
        $shipping = $this->order->shipping_amount;
        $discounts = $this->order->discount_amount;
        $payments = $this->order->paid_amount;
        
        return $subtotal + $taxes + $shipping - $discounts - $payments;
    }
}
