<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class County extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_id',
        'name',
        'code',
        'tax_rate',
    ];

    protected function casts(): array
    {
        return [
            'tax_rate' => 'decimal:3',
        ];
    }

    protected function taxRate(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => str_pad($value, 3, '0', STR_PAD_RIGHT),
        );
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
