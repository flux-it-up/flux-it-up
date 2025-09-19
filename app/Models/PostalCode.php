<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostalCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'state',
        'county',
        'city',
        'postal_code',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
