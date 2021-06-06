<?php

namespace App\Events\Tax;

use App\Models\Tax;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaxCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Tax $tax;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Tax $tax)
    {
        //
        $this->tax = $tax;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
