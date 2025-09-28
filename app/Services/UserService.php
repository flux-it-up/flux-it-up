<?php

namespace App\Services;

use App\Models\User;
use App\Models\State;
use App\Models\County;
use App\Models\City;

class UserService
{
    public User $user;

    /**
     * Create a new class instance.
     */
    public function __construct($userId)
    {
        $this->user = User::with('defaultShippingAddress','defaultBillingAddress')->findOrFail($userId);
    }

    public function getUserStateTax()
    {
        $state_id = $this->user->defaultShippingAddress->state_id;
        $state = State::select('tax_rate')->find($state_id);
        return $state->tax_rate ?? 0.00;
    }

    public function getUserCountyTax()
    {
        $county_id = $this->user->defaultShippingAddress->county_id;
        $county = County::select('tax_rate')->find($county_id);
        return $county->tax_rate ?? 0.00;
    }

    public function getUserCityTax()
    {
        $city_id = $this->user->defaultShippingAddress->city_id;
        $city = City::select('tax_rate')->find($city_id);
        return $city->tax_rate ?? 0.00;
    }
}
