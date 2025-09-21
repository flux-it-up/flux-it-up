<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;

class OrderService
{
    protected $state_tax_rate = 0;
    protected $county_tax_rate = 0;
    protected $city_tax_rate = 0;
    protected $user;
    
    public function __construct($userId)
    {
        $this->user = User::with('defaultShippingAddress')->findOrFail($userId);
        dd($this->user);
    }

    public function createOrder($order, $services = null, $products = null)
    {

    }
}
