<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Address extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $fillable = [
        'user_id', 'type', 'label', 'line1', 'line2',
        'city_id', 'county_id', 'state_id', 'postal_code', 'country', 'is_default'
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getIsDefaultAttribute($value)
    {
        return (bool) $value;
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
