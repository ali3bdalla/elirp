<?php

namespace App\Notifications\Document;

use App\Domains\Document\Jobs\GetDocumentPdfJob;
use App\Enums\DocumentTypeEnum;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentRefundedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    use DocumentNotification;

    private Document $document;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->document=$document;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $invoice=$this->run(GetDocumentPdfJob::class, ['document'=>$this->document]);
        return (new MailMessage)->subject($this->document->document_number.' Refunded ')->greeting('Dear '.$notifiable->name.'!')->line('Document: '.$this->document->document_number.'  has been refunded!')->line('please have look into this mail attachments')->line('Thank you for using our application!')->attachData($invoice->download(), $this->document->document_number.'.pdf', ['mime'=>'application/pdf', ]);
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
