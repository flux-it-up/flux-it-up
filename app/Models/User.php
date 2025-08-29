<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Carbon $email_verified_at
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? Storage::disk('public')->url($this->avatar)
            : Storage::disk('public')->url('avatars/profile_avatar_placeholder.png');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function shippingAddresses()
    {
        return $this->addresses()->where('type', 'shipping');
    }

    public function billingAddresses()
    {
        return $this->addresses()->where('type', 'billing');
    }

    public function defaultShipping()
    {
        return $this->addresses()->where('type', 'shipping')->where('is_default', true)->first();
    }

    public function defaultBilling()
    {
        return $this->addresses()->where('type', 'billing')->where('is_default', true)->first();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
