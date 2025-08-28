<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Livewire\Traits\GeneratesSku;

class Service extends Model
{
    use HasFactory, SoftDeletes, HasRoles, GeneratesSku;

    protected $fillable = [
        'name', 
        'description', 
        'category', 
        'code',
        'base_price', 
        'estimated_time',
        'sku',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
        ];
    }

    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($service) {
            $service->sku = $service->generatesServiceSku();
        });
    }

    public function consoles()
    {
        return $this->belongsToMany(Console::class)
            ->withPivot(['price_adjustment','sku'])
            ->withTimestamps();
    }

    public function pricingTiers()
    {
        return $this->belongsToMany(PricingTier::class);
    }
}
