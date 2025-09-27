<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Notification extends DatabaseNotification
{
    protected $fillable = [
        'id',
        'type',
        'title',
        'icon',
        'color',
        'notifiable_type',
        'notifiable_id',
        'data',
        'action_url',
        'action_text',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    #[Scope]
    public function byColor(Builder $query, string $color): void
    {
        $query->where('color', $color);
    }

    #[Scope]
    public function withAction(Builder $query): void
    {
        $query->whereNotNull('action_url')->whereNotNull('action_text');
    }

    #[Scope]
    public function byTitle(Builder $query, string $title): void
    {
        $query->where('title', 'like', "%$title%");
    }

    #[Scope]
    public function ofType(Builder $query, string $type): void
    {
        $query->where('type', $type);
    }

    #[Scope]
    public function highPriority(Builder $query): void
    {
        $query->whereJsonContains('data->priority', 'high');
    }

    #[Scope]
    public function forOrder(Builder $query, int $orderId): void
    {
        $query->whereJsonContains('data->order_id', $orderId);
    }

    #[Scope]
    public function byStatus(Builder $query, string $status): void
    {
        $query->whereJsonContains('data->status', $status);
    }

    #[Scope]
    public function recent(Builder $query, int $days = 30): void
    {
        $query->where('created_at', '>=', now()->subDays($days));
    }

    #[Scope]
    public function today(Builder $query): void
    {
        $query->whereDate('created_at', today());
    }

    #[Scope]
    public function dateRange(Builder $query, string $startDate, string $endDate): void
    {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    #[Scope]
    public function priority(Builder $query, string $level): void
    {
        $query->whereJsonContains('data->priority', $level);
    }

    #[Scope]
    public function orderNotifications(Builder $query): void
    {
        $query->where('type', 'App\Notifications\OrderStatusUpdated');
    }

    #[Scope]
    public function repairNotifications(Builder $query): void
    {
        $query->where('type', 'App\Notifications\NewRepairOrderReceived');
    }

    #[Scope]
    public function colors(Builder $query, array $colors): void
    {
        $query->whereIn('color', $colors);
    }

    #[Scope]
    public function needsAttention(Builder $query): void
    {
        $query->whereNull('read_at')
            ->whereJsonContains('data->priority', 'high');
    }

    #[Scope]
    public function search(Builder $query, string $term): void
    {
        $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%$term%")
                ->orWhereJsonContains('data->message', $term);
        });
    }
}
