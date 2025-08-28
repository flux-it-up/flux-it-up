<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $fillable = [
        'name',
        'description',
    ];

    public function product() 
    {
        return $this->hasOne(Product::class);
    }
}
