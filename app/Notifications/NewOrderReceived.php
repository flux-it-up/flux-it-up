<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class NewOrderReceived extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['fiu_database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        try {
            $customerName = $this->order->user?->name ?? 'Unknown Customer';

            $data = [
                'title' => 'New Order Received',
                'icon' => 'shopping-bag',
                'color' => 'emerald',
                'action_url' => route('admin.orders.show', $this->order->id),
                'action_text' => 'View Order',
                'data' => [
                    'message' => "New order awaiting confirmation.",
                    'order_id' => $this->order->id,
                    'order_number' => $this->order->order_number,
                    'customer_name' => $customerName,
                ]
            ];

            return $data;

        } catch (\Exception $e) {
            Log::error('Error in notification toDatabase', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            //Return minimal data if there's an error
            return [
                'title' => 'New Order Received',
                'icon' => 'shopping-bag',
                'color' => 'emerald',
                'data' => [
                    'message' => 'New order awaiting confirmation',
                ]
            ];
        }
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Order Received')
            ->line('A new order has been placed and is awaiting confirmation.')
            ->line('Order: #{$this->order->order_number}')
            ->line('Customer: {$this->order->user->name}')
            ->action('View Order', route('admin.order.show', $this->order->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
