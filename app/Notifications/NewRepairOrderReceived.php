<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\RepairRequest;
use Illuminate\Support\Facades\Log;

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
        return ['fiu_database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
         try {
            // Safely get brand name
            $brandName = $this->repairRequest->console?->brand?->name ?? 'Unknown Brand';
            $model = $this->repairRequest->console?->model ?? 'Unknown Model';
            $customerName = $this->repairRequest->user?->name ?? 'Unknown Customer';
            
            $data = [
                'title' => 'New Repair Order Received',
                
                'icon' => 'plus-circle',
                'color' => 'blue',
                'action_url' => route('admin.repairs.show', $this->repairRequest->id),
                'action_text' => 'View Repair Order',
                'data' => [
                    'message' => "New repair request for {$brandName} {$model} from {$customerName}",
                    'order_id' => $this->repairRequest->order?->id,
                    'order_number' => $this->repairRequest->order?->order_number,
                    'customer_name' => $customerName,
                ]
            ];

            return $data;

        } catch (\Exception $e) {
            Log::error('Error in notification toDatabase', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return minimal data if there's an error
            return [
                'title' => 'New Repair Order Received',
                'message' => 'A new repair request has been submitted',
                'icon' => 'plus-circle',
                'color' => 'blue',
            ];
        }
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
