<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Console;

class ConsoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Console::create([
            'brand_id' => '1',
            'model' => '3',
            'image' => 'consoles/playstation/playstation-3.png',
        ]);
        Console::create([
            'brand_id' => '1',
            'model' => '3 Slim',
            'image' => 'consoles/playstation/playstation-3-slim.png',
        ]);
        Console::create([
            'brand_id' => '1',
            'model' => '3 Super Slim',
            'image' => 'consoles/playstation/playstation-3-super-slim.png',
        ]);
        Console::create([
            'brand_id' => '2',
            'model' => 'One',
            'image' => 'consoles/xbox/xbox-one.png',
        ]);
        Console::create([
            'brand_id' => '2',
            'model' => 'One S',
            'image' => 'consoles/xbox/xbox-one-s.png',
        ]);
        Console::create([
            'brand_id' => '2',
            'model' => 'One X',
            'image' => 'consoles/xbox/xbox-one-x.png',
        ]);
        Console::create([
            'brand_id' => '1',
            'model' => '4',
            'image' => 'consoles/playstation/playstation-4.png',
        ]);
        Console::create([
            'brand_id' => '1',
            'model' => '4 Slim',
            'image' => 'consoles/playstation/playstation-4-slim.png',
        ]);
        Console::create([
            'brand_id' => '1',
            'model' => '4 Pro',
            'image' => 'consoles/playstation/playstation-4-pro.png',
        ]);
        Console::create([
            'brand_id' => '2',
            'model' => 'Series S',
            'image' => 'consoles/xbox/xbox-series-s.png',
        ]);
        Console::create([
            'brand_id' => '2',
            'model' => 'Series X',
            'image' => 'consoles/xbox/xbox-series-x.png',
        ]);
        Console::create([
            'brand_id' => '1',
            'model' => '5',
            'image' => 'consoles/playstation/playstation-5.png',
        ]);
        Console::create([
            'brand_id' => '1',
            'model' => '5 Slim',
            'image' => 'consoles/playstation/playstation-5-slim.png',
        ]);
        Console::create([
            'brand_id' => '1',
            'model' => '5 Pro',
            'image' => 'consoles/playstation/playstation-5-pro.png',
        ]);
        Console::create([
            'brand_id' => '3',
            'model' => 'Switch',
            'image' => 'consoles/nintendo/nintendo-switch.png',
        ]);
        Console::create([
            'brand_id' => '3',
            'model' => 'Switch Lite',
            'image' => 'consoles/nintendo/nintendo-switch-lite.png',
        ]);
        Console::create([
            'brand_id' => '3',
            'model' => 'Switch OLED',
            'image' => 'consoles/nintendo/nintendo-switch-oled.png',
        ]);
        Console::create([
            'brand_id' => '3',
            'model' => 'Switch 2',
            'image' => 'consoles/nintendo/nintendo-switch-2.png',
        ]);
        Console::create([
            'brand_id' => '3',
            'model' => '3DS',
            'image' => 'consoles/nintendo/nintendo-3ds.png',
        ]);
    }
}
