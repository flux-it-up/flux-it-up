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
        Console::factory()->create([
            'brand' => 'PlayStation',
            'model' => '3'
        ]);
        Console::factory()->create([
            'brand' => 'PlayStation',
            'model' => '3 Slim'
        ]);
        Console::factory()->create([
            'brand' => 'PlayStation',
            'model' => '3 Super Slim'
        ]);
        Console::factory()->create([
            'brand' => 'Xbox',
            'model' => 'One'
        ]);
        Console::factory()->create([
            'brand' => 'Xbox',
            'model' => 'One S'
        ]);
        Console::factory()->create([
            'brand' => 'Xbox',
            'model' => 'One X'
        ]);
        Console::factory()->create([
            'brand' => 'PlayStation',
            'model' => '4'
        ]);
        Console::factory()->create([
            'brand' => 'PlayStation',
            'model' => '4 Slim'
        ]);
        Console::factory()->create([
            'brand' => 'PlayStation',
            'model' => '4 Pro'
        ]);
        Console::factory()->create([
            'brand' => 'Xbox',
            'model' => 'Series S'
        ]);
        Console::factory()->create([
            'brand' => 'Xbox',
            'model' => 'Series X'
        ]);
        Console::factory()->create([
            'brand' => 'PlayStation',
            'model' => '5'
        ]);
        Console::factory()->create([
            'brand' => 'PlayStation',
            'model' => '5 Slim'
        ]);
        Console::factory()->create([
            'brand' => 'PlayStation',
            'model' => '5 Pro'
        ]);
    }
}
