<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Hardware Repair', 'description' => 'Physical component repairs and replacements'],
            ['name' => 'Software Issues', 'description' => 'System software and firmware problems'],
            ['name' => 'Cleaning & Maintenance', 'description' => 'Console cleaning and preventive maintenance'],
            ['name' => 'Controller Repair', 'description' => 'Game controller repairs and modifications'],
            ['name' => 'Display Issues', 'description' => 'Screen and display related problems'],
            ['name' => 'Audio Problems', 'description' => 'Sound and audio system repairs'],
            ['name' => 'Network Connectivity', 'description' => 'WiFi and network connection issues'],
            ['name' => 'Storage Solutions', 'description' => 'Hard drive and storage upgrades'],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}
