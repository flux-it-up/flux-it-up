<?php

namespace App\Models;

use App\Notifications\NewRepairOrderReceived;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'user_id', 'console_model_id', 'service_id', 
        'console_serial_number', 'issue_description', 'customer_notes', 
        'repair_status', 'priority', 'estimated_completion', 'actual_completion', 
        'technician_id', 'repair_cost', 'parts_cost', 'labor_cost', 
        'total_cost', 'warranty_expires'
    ];

    protected $casts = [
        'estimated_completion' => 'date',
        'actual_completion' => 'datetime',
        'warranty_expires' => 'date',
        'repair_cost' => 'decimal:2',
        'parts_cost' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($repairRequest) {
            // Notify customer
            $repairRequest->user->notify(new OrderStatusUpdated($repairRequest->order));

            // Notify admins
            $admins = User::role(['super-admin','admin'])->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewRepairOrderReceived($repairRequest));
            }
        });

        static::updated(function ($repairRequest) {
            if($repairRequest->order->wasChanged('order_status')) {
                $repairRequest->user->notify(new OrderStatusUpdated($repairRequest));
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function console()
    {
        return $this->belongsTo(Console::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'repair_request_service', 'repair_request_id', 'service_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function statusHistory()
    {
        return $this->hasMany(RepairStatusHistory::class, 'repair_id');
    }

    public function partsUsed()
    {
        return $this->hasMany(RepairPartsUsed::class, 'repair_id');
    }

    public function images()
    {
        return $this->hasMany(RepairImage::class, 'repair_id');
    }
}
