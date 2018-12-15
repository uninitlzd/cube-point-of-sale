<?php

namespace App\Events;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmployeeRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $employee;
    public $shop;
    public $password;

    /**
     * Create a new event instance.
     *
     * @param User $employee
     * @param Shop $shop
     * @param $password
     */
    public function __construct(User $employee, Shop $shop, $password)
    {
        $this->employee = $employee;
        $this->shop = $shop;
        $this->password = $password;
    }
}
