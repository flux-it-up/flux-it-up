<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Notification;

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
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'dob',
        'phone',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected  $appends = ['name'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date:Y-m-d',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->assignRole('customer');
        });
    }

    public function getAvatarUrlAttribute()
    {
         return Cache::remember("user_avatar_{$this->id}", 3600, function () {
            return $this->avatar && Storage::disk('public')->exists($this->avatar)
                ? Storage::disk('public')->url($this->avatar)
                : Storage::disk('public')->url('avatars/profile_avatar_placeholder.png');
        });
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->middle_name.' '.$this->last_name;
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

    public function defaultShippingAddress()
    {
        return $this->hasOne(Address::class)
                ->where('type', 'shipping')
                ->where('is_default', true);
    }

    public function defaultBillingAddress()
    {
        return $this->hasOne(Address::class)
                ->where('type', 'billing')
                ->where('is_default', true);
    }

    public function scopeWithDefaultShipping(Builder $query)
    {
        return $query->whereHas('defaultShippingAddress');
    }

    public function scopeWithDefaultBilling(Builder $query)
    {
        return $query->whereHas('defaultBillingAddress');
    }

    public function hasDefaultShippingAddress(): bool
    {
        return $this->defaultShippingAddress()->exists();
    }

    public function hasDefaultBillingAddress(): bool
    {
        return $this->defaultBillingAddress()->exists();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc');
    }
}
