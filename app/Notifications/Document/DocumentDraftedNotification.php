<?php

namespace App\Notifications\Document;

use App\Models\Contact;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentDraftedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $afterCommit = true;
    private Document $document;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Document  $document)
    {
        $this->document=$document;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(Contact $notifiable): array
    {
        return [$notifiable->preferredNotificationChannel(),'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/documents/'.$this->document->id);
        return (new MailMessage)
            ->greeting('Hello!')
            ->line('One of your Document has been created!')
            ->action('View Document', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
