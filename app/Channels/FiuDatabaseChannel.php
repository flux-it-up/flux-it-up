<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class FiuDatabaseChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);
        
        // Extract the nested data array
        $nestedData = $data['data'] ?? [];
        
        // Remove the nested data from the main array to avoid duplication
        unset($data['data']);
        
        $payload = [
            'id' => $notification->id,
            'type' => get_class($notification),
            'notifiable_type' => $notifiable->getMorphClass(),
            'notifiable_id' => $notifiable->getKey(),
            'title' => $data['title'] ?? null,
            'icon' => $data['icon'] ?? null,
            'color' => $data['color'] ?? null,
            'level' => $data['level'] ?? 'info',
            'priority' => $data['priority'] ?? 'normal',
            'action_url' => $data['action_url'] ?? null,
            'action_text' => $data['action_text'] ?? null,
            'data' => json_encode($nestedData), // Store only the nested data
            'read_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        return app('db')->table('notifications')->insert($payload);
    }
}
