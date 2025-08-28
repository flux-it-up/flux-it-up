<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Livewire\Traits\ConsoleCode;

class Console extends Model
{
    use HasFactory, SoftDeletes, HasRoles, ConsoleCode;

    protected $fillable = [
        'brand',
        'model',
        'code'
    ];

    protected $casts = [

    ];

    public function services()
    {
        return $this->belongsToMany(Service::class)
            ->withPivot(['price_adjustment','sku'])
            ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($console) {
            $console->name = $console->brand .' '.$console->model;
            $console->code = ConsoleCode::getConsoleCode($console);
        });
    }
}
