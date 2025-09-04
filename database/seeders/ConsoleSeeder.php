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
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '3 Slim',
            'model_number' => 'CECH-30xx',
            'release_year' => '2011',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '3 Super Slim',
            'model_number' => 'CECH-43xx',
            'release_year' => '2017',
        ]);
        Console::create([
            'brand' => 'Xbox',
            'model' => 'One',
            'model_number' => '1540',
            'release_year' => '2013',
        ]);
        Console::create([
            'brand' => 'Xbox',
            'model' => 'One S',
            'model_number' => '1681',
            'release_year' => '2016',
        ]);
        Console::create([
            'brand' => 'Xbox',
            'model' => 'One X',
            'model_number' => '1787',
            'release_year' => '2017',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '4',
            'model_number' => 'CUH-12xx',
            'release_year' => '2015',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '4 Slim',
            'model_number' => 'CUH-22xx',
            'release_year' => '2023',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '4 Pro',
            'model_number' => 'CUH-72xx',
            'release_year' => '2023',
        ]);
        Console::create([
            'brand' => 'Xbox',
            'model' => 'Series S',
            'model_number' => '1881',
            'release_year' => '2020',
        ]);
        Console::create([
            'brand' => 'Xbox',
            'model' => 'Series X',
            'model_number' => '1882',
            'release_year' => '2020',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '5',
            'model_number' => 'CFI-1215B',
            'release_year' => '2022',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '5 Slim',
            'model_number' => 'CFI-2000B',
            'release_year' => '2023',
        ]);
        Console::create([
            'brand' => 'PlayStation',
            'model' => '5 Pro',
            'model_number' => 'CFI-7021',
            'release_year' => '2024',
        ]);
    }
}
