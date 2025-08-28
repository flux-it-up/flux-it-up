<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesTaxNexusThresholdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['region' => 'Alabama', 'type' => 'state', 'sales_threshold' => 250000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Alaska (local only)', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Arizona', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Arkansas', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'California', 'type' => 'state', 'sales_threshold' => 500000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Colorado', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Connecticut', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Delaware', 'type' => 'state', 'sales_threshold' => null, 'transaction_threshold' => null, 'has_sales_tax' => false],
            ['region' => 'District of Columbia', 'type' => 'territory', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Florida', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Georgia', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Hawaii', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Idaho', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Illinois', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Indiana', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Iowa', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Kansas', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Kentucky', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Louisiana', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Maine', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Maryland', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Massachusetts', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Michigan', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Minnesota', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Mississippi', 'type' => 'state', 'sales_threshold' => 250000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Missouri', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Montana', 'type' => 'state', 'sales_threshold' => null, 'transaction_threshold' => null, 'has_sales_tax' => false],
            ['region' => 'Nebraska', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Nevada', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'New Hampshire', 'type' => 'state', 'sales_threshold' => null, 'transaction_threshold' => null, 'has_sales_tax' => false],
            ['region' => 'New Jersey', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'New Mexico', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'New York', 'type' => 'state', 'sales_threshold' => 500000, 'transaction_threshold' => 100, 'has_sales_tax' => true],
            ['region' => 'North Carolina', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'North Dakota', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Ohio', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Oklahoma', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Oregon', 'type' => 'state', 'sales_threshold' => null, 'transaction_threshold' => null, 'has_sales_tax' => false],
            ['region' => 'Pennsylvania', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Rhode Island', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'South Carolina', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'South Dakota', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Tennessee', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Texas', 'type' => 'state', 'sales_threshold' => 500000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'Utah', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Vermont', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Virginia', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Washington', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'West Virginia', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Wisconsin', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Wyoming', 'type' => 'state', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],

            // Territories
            ['region' => 'Puerto Rico', 'type' => 'territory', 'sales_threshold' => 100000, 'transaction_threshold' => 200, 'has_sales_tax' => true],
            ['region' => 'Guam', 'type' => 'territory', 'sales_threshold' => null, 'transaction_threshold' => null, 'has_sales_tax' => false],
            ['region' => 'U.S. Virgin Islands', 'type' => 'territory', 'sales_threshold' => null, 'transaction_threshold' => null, 'has_sales_tax' => true],
            ['region' => 'American Samoa', 'type' => 'territory', 'sales_threshold' => null, 'transaction_threshold' => null, 'has_sales_tax' => false],
            ['region' => 'Northern Mariana Islands', 'type' => 'territory', 'sales_threshold' => null, 'transaction_threshold' => null, 'has_sales_tax' => false],
        ];

        DB::table('sales_tax_nexus_thresholds')->insert($data);
    }
}
