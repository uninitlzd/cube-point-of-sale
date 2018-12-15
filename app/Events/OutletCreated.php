<?php

namespace App\Events;

use App\Models\Shop;
use App\Models\ShopOutlet;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OutletCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $outlet;

    /**
     * Create a new event instance.
     *
     * @param ShopOutlet $outlet
     */
    public function __construct(ShopOutlet $outlet)
    {
        $this->outlet = $outlet;
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
