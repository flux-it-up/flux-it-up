<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_id',
        'county_id',
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

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function postal_codes()
    {
        return $this->hasMany(PostalCode::class);
    }
}
