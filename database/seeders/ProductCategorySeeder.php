<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::factory()->create([
            'name' => 'Replacement Parts',
            'description' => 'Internal components and replacement parts for console repairs',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Controllers & Input',
            'description' => 'Controllers, gamepads, and input device components',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Power & Charging',
            'description' => 'Power supplies, adapters, batteries, and charging accessories',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Storage & Memory',
            'description' => 'Hard drives, memory cards, and storage solutions',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Display & Audio',
            'description' => 'Screen components, HDMI parts, speakers, and audio components',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Cables & Connectors',
            'description' => 'Various cables, ports, and connector components',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Tools & Supplies',
            'description' => 'Repair tools, cleaning supplies, and maintenance equipment',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Protective Accessories',
            'description' => 'Cases, covers, screen protectors, and protective gear',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Console Modifications',
            'description' => 'Custom parts, LED kits, and modification components',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Refurbished Systems',
            'description' => 'Fully refurbished and tested console systems',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'PlayStation Parts',
            'description' => 'Parts specifically for PlayStation consoles',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Xbox Parts',
            'description' => 'Parts specifically for Xbox consoles',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Nintendo Parts',
            'description' => 'Parts specifically for Nintendo consoles',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Handheld Components',
            'description' => 'Parts for portable gaming devices',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ProductCategory::factory()->create([
            'name' => 'Networking Components',
            'description' => 'WiFi, Bluetooth, and network-related parts',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
