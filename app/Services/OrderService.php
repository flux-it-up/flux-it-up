<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;
use App\Services\UserService;

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

    public function createAdminProductOrder($order, $products = null)
    {
        //Prepare order data
        $order->shipping_address_id = $this->user->defaultShippingAddress->id;
        $order->billing_address_id = $this->user->defaultBillingAddress->id;
        $order->subtotal = $this->calculateSubtotal($products);
        $order->tax_amount = $this->calculateTaxes();
        $order->shipping_amount = $this->calculateShipping();
        if($this->verifyDiscountCode()){
            $order->discount_amount = $this->getDiscountAmount();
        }
        $order->paid_amount = $this->getPayments();
        $order->total_amount = $this->calculateTotal();
        $order->save();

        $pivotData = [];
        foreach($products as $product) {
            $pivotData[$product['id']] = ['quantity'=>$product['quantity']];
        }
        $this->order->products()->sync($pivotData);
    }

    public function calculateSubtotal($products = null)
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
        // Return true for now
        return true;
    }

    public function getDiscountAmount()
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
