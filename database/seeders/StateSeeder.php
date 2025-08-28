<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['code' => 'AL', 'name' => 'Alabama', 'tax_rate' => 4.00],
            ['code' => 'AK', 'name' => 'Alaska', 'tax_rate' => 0.00], // no state tax
            ['code' => 'AZ', 'name' => 'Arizona', 'tax_rate' => 5.60],
            ['code' => 'AR', 'name' => 'Arkansas', 'tax_rate' => 6.50],
            ['code' => 'CA', 'name' => 'California', 'tax_rate' => 7.25],
            ['code' => 'CO', 'name' => 'Colorado', 'tax_rate' => 2.90],
            ['code' => 'CT', 'name' => 'Connecticut', 'tax_rate' => 6.35],
            ['code' => 'DE', 'name' => 'Delaware', 'tax_rate' => 0.00], // no state tax
            ['code' => 'FL', 'name' => 'Florida', 'tax_rate' => 6.00],
            ['code' => 'GA', 'name' => 'Georgia', 'tax_rate' => 4.00],
            ['code' => 'HI', 'name' => 'Hawaii', 'tax_rate' => 4.00],
            ['code' => 'ID', 'name' => 'Idaho', 'tax_rate' => 6.00],
            ['code' => 'IL', 'name' => 'Illinois', 'tax_rate' => 6.25],
            ['code' => 'IN', 'name' => 'Indiana', 'tax_rate' => 7.00],
            ['code' => 'IA', 'name' => 'Iowa', 'tax_rate' => 6.00],
            ['code' => 'KS', 'name' => 'Kansas', 'tax_rate' => 6.50],
            ['code' => 'KY', 'name' => 'Kentucky', 'tax_rate' => 6.00],
            ['code' => 'LA', 'name' => 'Louisiana', 'tax_rate' => 4.45],
            ['code' => 'ME', 'name' => 'Maine', 'tax_rate' => 5.50],
            ['code' => 'MD', 'name' => 'Maryland', 'tax_rate' => 6.00],
            ['code' => 'MA', 'name' => 'Massachusetts', 'tax_rate' => 6.25],
            ['code' => 'MI', 'name' => 'Michigan', 'tax_rate' => 6.00],
            ['code' => 'MN', 'name' => 'Minnesota', 'tax_rate' => 6.875],
            ['code' => 'MS', 'name' => 'Mississippi', 'tax_rate' => 7.00],
            ['code' => 'MO', 'name' => 'Missouri', 'tax_rate' => 4.225],
            ['code' => 'MT', 'name' => 'Montana', 'tax_rate' => 0.00], // no state tax
            ['code' => 'NE', 'name' => 'Nebraska', 'tax_rate' => 5.50],
            ['code' => 'NV', 'name' => 'Nevada', 'tax_rate' => 6.85],
            ['code' => 'NH', 'name' => 'New Hampshire', 'tax_rate' => 0.00], // no state tax
            ['code' => 'NJ', 'name' => 'New Jersey', 'tax_rate' => 6.625],
            ['code' => 'NM', 'name' => 'New Mexico', 'tax_rate' => 5.125],
            ['code' => 'NY', 'name' => 'New York', 'tax_rate' => 4.00],
            ['code' => 'NC', 'name' => 'North Carolina', 'tax_rate' => 4.75],
            ['code' => 'ND', 'name' => 'North Dakota', 'tax_rate' => 5.00],
            ['code' => 'OH', 'name' => 'Ohio', 'tax_rate' => 5.75],
            ['code' => 'OK', 'name' => 'Oklahoma', 'tax_rate' => 4.50],
            ['code' => 'OR', 'name' => 'Oregon', 'tax_rate' => 0.00], // no state tax
            ['code' => 'PA', 'name' => 'Pennsylvania', 'tax_rate' => 6.00],
            ['code' => 'RI', 'name' => 'Rhode Island', 'tax_rate' => 7.00],
            ['code' => 'SC', 'name' => 'South Carolina', 'tax_rate' => 6.00],
            ['code' => 'SD', 'name' => 'South Dakota', 'tax_rate' => 4.50],
            ['code' => 'TN', 'name' => 'Tennessee', 'tax_rate' => 7.00],
            ['code' => 'TX', 'name' => 'Texas', 'tax_rate' => 6.25],
            ['code' => 'UT', 'name' => 'Utah', 'tax_rate' => 4.85],
            ['code' => 'VT', 'name' => 'Vermont', 'tax_rate' => 6.00],
            ['code' => 'VA', 'name' => 'Virginia', 'tax_rate' => 5.30],
            ['code' => 'WA', 'name' => 'Washington', 'tax_rate' => 6.50],
            ['code' => 'WV', 'name' => 'West Virginia', 'tax_rate' => 6.00],
            ['code' => 'WI', 'name' => 'Wisconsin', 'tax_rate' => 5.00],
            ['code' => 'WY', 'name' => 'Wyoming', 'tax_rate' => 4.00],
            ['code' => 'DC', 'name' => 'District of Columbia', 'tax_rate' => 6.00],
            // Territories
            ['code' => 'PR', 'name' => 'Puerto Rico', 'tax_rate' => 10.50],
            ['code' => 'GU', 'name' => 'Guam', 'tax_rate' => 4.00],
            ['code' => 'VI', 'name' => 'U.S. Virgin Islands', 'tax_rate' => 5.00],
        ];

        foreach ($states as $state) {
            State::updateOrCreate(
                ['code' => $state['code']],
                ['name' => $state['name'], 'tax_rate' => $state['tax_rate']]
            );
        }
    }
}
