<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneratesCode;

class Console extends Model
{
    use HasFactory, SoftDeletes, GeneratesCode;

    protected $fillable = [
        'brand_id',
        'model',
        'model_number',
        'release_year',
        'image',
        'specifications',
        'code'
    ];

    protected $casts = [

    ];

    public function brand()
    {
        return $this->belongsTo(ConsoleBrand::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'console_service', 'console_id', 'service_id')
            ->withPivot(['price_adjustment','sku'])
            ->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function models()
    {
        return $this->hasMany(ConsoleModel::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($console) {
            $console->name = $console->brand->name .' '.$console->model;
            $console->code = $console->getConsoleCode();
        });
    }
}
