<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class ProductImages extends Model
{
    use HasRoles;

    protected $fillable = [
        'image_url', 
        'alt_text',
        'sort_order',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }
}
