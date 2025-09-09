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
            'brand' => 'PlayStation',
            'model' => '3',
            'model_number' => 'CECHKxx',
            'release_year' => '2008',
            'image' => 'consoles/playstation/playstation-3.png',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '3 Slim',
            'model_number' => 'CECH-30xx',
            'release_year' => '2011',
            'image' => 'consoles/playstation/playstation-3-slim.png',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '3 Super Slim',
            'model_number' => 'CECH-43xx',
            'release_year' => '2017',
            'image' => 'consoles/playstation/playstation-3-super-slim.png',
        ]);
        Console::create([
            'brand' => 'Xbox',
            'model' => 'One',
            'model_number' => '1540',
            'release_year' => '2013',
            'image' => 'consoles/xbox/xbox-one.png',
        ]);
        Console::create([
            'brand' => 'Xbox',
            'model' => 'One S',
            'model_number' => '1681',
            'release_year' => '2016',
            'image' => 'consoles/xbox/xbox-one-s.png',
        ]);
        Console::create([
            'brand' => 'Xbox',
            'model' => 'One X',
            'model_number' => '1787',
            'release_year' => '2017',
            'image' => 'consoles/xbox/xbox-one-x.png',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '4',
            'model_number' => 'CUH-12xx',
            'release_year' => '2015',
            'image' => 'consoles/playstation/playstation-4.png',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '4 Slim',
            'model_number' => 'CUH-22xx',
            'release_year' => '2023',
            'image' => 'consoles/playstation/playstation-4-slim.png',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '4 Pro',
            'model_number' => 'CUH-72xx',
            'release_year' => '2023',
            'image' => 'consoles/playstation/playstation-4-pro.png',
        ]);
        Console::create([
            'brand' => 'Xbox',
            'model' => 'Series S',
            'model_number' => '1881',
            'release_year' => '2020',
            'image' => 'consoles/xbox/xbox-series-s.png',
        ]);
        Console::create([
            'brand' => 'Xbox',
            'model' => 'Series X',
            'model_number' => '1882',
            'release_year' => '2020',
            'image' => 'consoles/xbox/xbox-series-x.png',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '5',
            'model_number' => 'CFI-1215B',
            'release_year' => '2022',
            'image' => 'consoles/playstation/playstation-5.png',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '5 Slim',
            'model_number' => 'CFI-2000B',
            'release_year' => '2023',
            'image' => 'consoles/playstation/playstation-5-slim.png',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '5 Pro',
            'model_number' => 'CFI-7021',
            'release_year' => '2024',
            'image' => 'consoles/playstation/playstation-5-pro.png',
        ]);
        Console::create([
            'brand' => 'Nintendo',
            'model' => 'Switch',
            'model_number' => 'HAC-001',
            'release_year' => '2017',
            'image' => 'consoles/nintendo/nintendo-switch.png',
        ]);
        Console::create([
            'brand' => 'Nintendo',
            'model' => 'Switch Lite',
            'model_number' => 'HDH-001',
            'release_year' => '2019',
            'image' => 'consoles/nintendo/nintendo-switch-lite.png',
        ]);
        Console::create([
            'brand' => 'Nintendo',
            'model' => 'Switch OLED',
            'model_number' => 'HEG-001',
            'release_year' => '2021',
            'image' => 'consoles/nintendo/nintendo-switch-oled.png',
        ]);
        Console::create([
            'brand' => 'Nintendo',
            'model' => 'Switch 2',
            'model_number' => 'BEE-001',
            'release_year' => '2025',
            'image' => 'consoles/nintendo/nintendo-switch-2.png',
        ]);
        Console::create([
            'brand' => 'Nintendo',
            'model' => '3DS',
            'model_number' => 'KTR-001',
            'release_year' => '2011',
            'image' => 'consoles/nintendo/nintendo-3ds.png',
        ]);
    }
}
