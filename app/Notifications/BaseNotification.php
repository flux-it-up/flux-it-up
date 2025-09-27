<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;

class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $title = 'Notification';
    protected string $message = 'You have a new notification.';
    protected string $icon = 'bell';
    protected string $color = 'blue';
    protected ?string $actionUrl = null;
    protected ?string $actionText = null;
    protected string $level = 'info'; // e.g., 'info', 'success', 'warning', 'error'
    protected string $priority = 'normal'; // e.g., 'low', 'normal', 'high'

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
        return ['database','mail', 'broadcast'];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $data = $this->toDatabase($notifiable);

        return new BroadcastMessage([
            'id' => $this->id,
            'type' => get_class($this),
            'title' => $data['title'] ?? 'Notification',
            'message' => $data['message'] ?? 'You have a new notification.',
            'icon' => $data['icon'] ?? 'bell',
            'color' => $data['color'] ?? 'blue',
            'action_url' => $data['action_url'] ?? null,
            'action_text' => $data['action_text'] ?? null,
            'level' => $this->level,
            'priority' => $this->priority,
            'created_at' => now()->toISOString(),
            'read_at' => null,
        ]);
    }

    /**
     * Get the array representation of the notification for database storage.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'color' => $this->color,
            'action_url' => $this->actionUrl,
            'action_text' => $this->actionText,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
                    ->subject($this->title)
                    ->greeting('Hello {notifiable->name}!')
                    ->line($this->message);
        if ($this->actionUrl && $this->actionText) {
            $mail->action($this->actionText, $this->actionUrl);
        }

        return $mail->line('Thank you for using our console repair service! We appreciate your business.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }

    /**
     * Set notification properties
     */
    protected function setNotificationData(
        string $title,
        string $message,
        string $icon = 'bell',
        string $color = 'blue',
        ?string $actionUrl = null,
        ?string $actionText = null
    ): self {
        $this->title = $title;
        $this->message = $message;
        $this->icon = $icon;
        $this->color = $color;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;

        return $this;
    }
}
