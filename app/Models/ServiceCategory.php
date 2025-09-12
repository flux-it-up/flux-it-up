<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = [
        'name', 
        'description',
    ];

    public function service()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
