<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Quote;


class QuoteApproved extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Quote $quote)
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
        return ['mail', 'database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'title' => 'Quote Approved - Repair Starting',
            'message' => "Your repair quote has been approved. We will start working on your console shortly.",
            'icon' => 'check-circle',
            'color' => 'green',
            'action_url' => route('quotes.show', $this->quote),
            'action_text' => 'View Quote',
            'quote_id' => $this->quote->id,
            'quote_number' => $this->quote->quote_number,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Quote Approved - Repair Starting')
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your repair quote has been approved.")
            ->line("We will start working on your console shortly.")
            ->action('View Quote', route('quotes.show', $this->quote))
            ->line('Thank you for choosing our console repair service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Quote Approved - Repair Starting',
            'message' => "Your repair quote has been approved. We will start working on your console shortly.",
            'icon' => 'check-circle',
            'color' => 'green',
            'action_url' => route('quotes.show', $this->quote),
            'action_text' => 'View Quote',
            'quote_id' => $this->quote->id,
            'quote_number' => $this->quote->quote_number,
        ];
    }
}
