<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ConsoleBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'logo'
    ];

    protected $casts = [

    ];

    public function consoles()
    {
        return $this->hasMany(Console::class, 'brand_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'console_service', 'console_id', 'service_id')
        ->join('consoles', 'consoles.id', '=', 'console_service.console_id')
        ->select('services.*', 'console_service.console_id')
        ->distinct();
    }

    public function getServicesAttribute()
    {
        return $this->consoles->flatMap->services->unique('id');
    }
}
