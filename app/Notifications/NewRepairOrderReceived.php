<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\RepairRequest;

class NewRepairOrderReceived extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public RepairRequest $repairRequest)
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
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Repair Order Received',
            'message' => 'New repair request for '.$this->repairRequest->console->brand->name.''.$this->repairRequest->console->model.' from '.$this->repairRequest->user->name,
            'icon' => 'plus-circle',
            'color' => 'blue',
            'action_url' => route('admin.repairs.show', $this->repairRequest->id),
            'action_text' => 'View Repair Order',
            'data' => [
                'order_id' => $this->repairRequest->order->id,
                'order_number' => $this->repairRequest->order->order_number,
                'customer_name' => $this->repairRequest->user->name,
            ]
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Repair Order Received')
            ->line('A new repair order has been received.')
            ->line('Order: #{$this->repairRequest->order->order_number}')
            ->line('Customer: {$this->repairRequest->user->name}')
            ->line('Console: {$this->repairRequest->console->brand} {$this->repairRequest->console->model}')
            ->line('Service: {$this->repairRequest->service->name}')
            ->action('View Repair Order', route('admin.repairs.show', $this->repairRequest->id));
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
