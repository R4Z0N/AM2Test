<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApartmentUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $apartment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($apartment)
    {
        $this->apartment = $apartment;
    }

}
