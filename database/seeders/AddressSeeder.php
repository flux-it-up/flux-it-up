<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::factory()->create([
            'user_id' => '1',
            'type' => 'shipping',
            'label' => 'Home',
            'line1' => '405 Dwain St.',
            'city' => 'Glenwood',
            'state' => 'AR',
            'postal_code' => '71943',
            'country' => 'United States of America',
            'is_default' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Address::factory()->create([
            'user_id' => '1',
            'type' => 'billing',
            'label' => 'Home',
            'line1' => '405 Dwain St.',
            'city' => 'Glenwood',
            'state' => 'AR',
            'postal_code' => '71943',
            'country' => 'United States of America',
            'is_default' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
