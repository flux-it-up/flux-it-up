<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsoleModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'console_id',
        'release_year',
        'storage_capacity'
    ];

    protected $casts = [
        'release_year' => 'integer',
    ];

    public function consoles()
    {
        return $this->belongsTo(Console::class, 'console_id');
    }
}
