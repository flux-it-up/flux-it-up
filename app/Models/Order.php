<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes, HasRoles;

    protected $fillable = [
        'user_id',
        'order_number',
        'order_type',
        'order_status',
        'payment_status',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'paid_amount',
        'total_amount',
        'currency',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'shipping_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function($order) {
            $order->order_number = 'ORD-'.now()->format('Ymd').'-'.Str::uuid();
        });
    }
}
