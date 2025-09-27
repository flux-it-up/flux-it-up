<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\Order;

class OrderStatusUpdated extends BaseNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public ?string $customMessage = null
    )
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail','broadcast'];
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => $this->getTitle(),
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
            'level' => $this->getLevel(),
            'priority' => $this->getPriority(),
            'action_url' => route('orders.show', $this->order),
            'action_text' => 'View Order',
            'data' => [
                'message' => $this->getMessage(),
                'order_id' => $this->order->id,
                'order_number' => $this->order->order_number,
                'status' => $this->order->status,
            ]
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->getTitle())
            ->greeting("Hello {$notifiable->name}!")
            ->line($this->getMessage())
            ->action('View Order Details', route('customer.orders.show', $this->order))
            ->line('If you have any questions, feel free to contact our support team.')
            ->line('Thank you for choosing our console repair service!');
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => 'order_status_updated',
            'title' => $this->getTitle(),
            'message' => $this->getMessage(),
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
            'action_url' => route('customer.orders.show', $this->order),
            'action_text' => 'View Order',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'status' => $this->order->status,
            'console_name' => $this->order->console->name,
            'created_at' => now()->toISOString(),
            'should_show_toast' => true,
            'level' => $this->getLevel(),
            'priority' => $this->getPriority(),
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            'users.'.$this->order->user_id,
        ];
    }

    /**
     * Customize the broadcast event name.
     */
    public function broadcastAs(): string
    {
        return 'order.status.updated';
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

    private function getLevel(): string
    {
        return match ($this->order->status) {
            'completed','delivered' => 'success',
            'cancelled','refunded' => 'error',
            'processing','shipped' => 'warning',
            default => 'info',
        };
    }

    private function getPriority(): string
    {
        return match ($this->order->status) {
            'completed','cancelled' => 'high',
            'diagnosed','in_progress' => 'medium',
            default => 'low',
        };
    }

    private function getTitle(): string
    {
        return match ($this->order->status) {
            'pending' => 'Order Received',
            'confirmed' => 'Order Confirmed',
            'processing' => 'Order Processing',
            'completed' => 'Order Completed',
            'shipped' => 'Order Shipped',
            'delivered' => 'Order Delivered',
            'cancelled' => 'Order Cancelled',
            'refunded' => 'Order Refunded',
            default => 'Order Updated'
        };
    }

    private function getMessage(): string
    {
        if ($this->customMessage) {
            return $this->customMessage;
        }

        return match ($this->order->status) {
            'pending' => "Your order #{$this->order->order_number} has been received and is pending confirmation.",
            'confirmed' => "Your order #{$this->order->order_number} has been confirmed. We will start processing it soon.",
            'processing' => "Your order #{$this->order->order_number} is currently being processed.",
            'completed' => "Your order #{$this->order->order_number} has been completed. Your console is working perfectly now!",
            'shipped' => "Good news! Your order #{$this->order->order_number} has been shipped.",
            'delivered' => "Your order #{$this->order->order_number} has been delivered. We hope you enjoy your fully functional console!",
            'cancelled' => "Your order #{$this->order->order_number} has been cancelled. If you have any questions, please contact our support team.",
            'refunded' => "Your order #{$this->order->order_number} has been refunded. Please check your account for details.",
            default => "Your order #{$this->order->order_number} status has been updated to: ".ucfirst(str_replace('_', ' ', $this->order->status)).".",
        };
    }

    private function getIcon(): string
    {
        return match ($this->order->status) {
            'pending' => 'clock',
            'confirmed' => 'hand-thumb-up',
            'processing' => 'wrench-screwdriver',
            'completed' => 'check-circle',
            'shipped' => 'truck',
            'delivered' => 'home-modern',
            'cancelled' => 'x-circle',
            'refunded' => 'receipt-refund',
            default => 'bell'
        };
    }

    private function getColor(): string
    {
        return match ($this->order->status) {
            'pending' => 'gray',
            'confirmed' => 'blue',
            'processing' => 'orange',
            'completed' => 'green',
            'shipped' => 'purple',
            'delivered' => 'teal',
            'cancelled' => 'red',
            'refunded' => 'yellow',
            default => 'blue'
        };
    }
}
