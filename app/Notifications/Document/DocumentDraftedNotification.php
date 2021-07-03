<?php

namespace App\Notifications\Document;

use App\Domains\Document\Jobs\GetDocumentPdfJob;
use App\Models\Contact;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Lucid\Bus\UnitDispatcher;

class DocumentDraftedNotification extends Notification implements ShouldQueue
{
    use UnitDispatcher;
    use Queueable;
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
//        $notifiable->preferredNotificationChannel(),'database'
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $invoice = $this->run(GetDocumentPdfJob::class, ['document' => $this->document]);
        return (new MailMessage)
            ->greeting('Hello!')
            ->line('One of your Document has been created!')
//            ->action('View Document', $url)
            ->line('Thank you for using our application!')
            ->attachData( $invoice->download(), 'name.pdf', [
                'mime' => 'application/pdf',
            ]);
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
