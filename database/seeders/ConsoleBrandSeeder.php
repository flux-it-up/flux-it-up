<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConsoleBrand;

class ConsoleBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConsoleBrand::create([
            'name' => 'PlayStation',
            'logo' => 'consoles/playstation/playstation-logo.png',
        ]);
        ConsoleBrand::create([
            'name' => 'Xbox',
            'logo' => 'consoles/xbox/xbox-logo.png',
        ]);
        ConsoleBrand::create([
            'name' => 'Nintendo',
            'logo' => 'consoles/nintendo/nintendo-logo.png',
        ]);
    }
}
