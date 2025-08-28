<?php

namespace App\Livewire\Traits;
use Illuminate\Support\Str;
use App\Models\Console;

trait ConsoleCode
{
    public static function getConsoleCode(Console $console)
    {
        $prefix = match($console->brand) {
            'PlayStation' => 'PS',
            'Xbox' => 'XB',
            'Nintendo' => 'N',
            default => 'GEN',
        };

        $model = Str::of($console->model)
            ->explode(' ')
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');

        $code = $prefix."".$model;

        return $code;
    }
}
