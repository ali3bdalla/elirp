<?php

namespace App\Events\Document;

use App\Models\Document;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BillDocumentCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Document $document;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        //
        $this->document = $document;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
