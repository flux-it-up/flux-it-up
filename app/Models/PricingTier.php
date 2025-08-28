<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class PricingTier extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $fillable = [
        'name', 'warranty', 'price', 'estimated_time'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
