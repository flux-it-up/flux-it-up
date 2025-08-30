<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Test Service',
            'description' => 'This is just a test service.',
            'category_id' => 1,
            'code' => 'HWR',
            'base_price' => 90,
            'estimated_time' => '4 hours',],
        ];

        foreach($services as $serviceData) {
            $service = Service::create($serviceData);

            $service->consoles()->attach(1, ['price_adjustment' => 20.00]);
        }
    }
}
