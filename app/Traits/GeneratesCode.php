<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait GeneratesCode
{
    public function generateConsoleCode()
    {
        $prefix = match($this->brand->name) {
            'PlayStation' => 'PS',
            'Xbox' => 'XB',
            'Nintendo' => 'N',
            default => 'GEN',
        };

        $model = Str::of($this->model)
            ->explode(' ')
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');

        return $prefix."".$model;
    }

    public function generateProductCode()
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
