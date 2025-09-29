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
            SalesTaxNexusThresholdsSeeder::class,
            StateSeeder::class,
            CountySeeder::class,
            //CitySeeder::class,
            ConsoleBrandSeeder::class,
            ConsoleSeeder::class,
            ConsoleModelSeeder::class,
            ProductCategorySeeder::class,
            ServiceCategorySeeder::class,
        ]);
    }
}
