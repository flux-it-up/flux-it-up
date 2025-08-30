<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AddressSeeder::class,
            StateSeeder::class,
            ConsoleSeeder::class,
            ProductCategorySeeder::class,
            SalesTaxNexusThresholdsSeeder::class,
            ServiceCategorySeeder::class,
        ]);
    }
}
