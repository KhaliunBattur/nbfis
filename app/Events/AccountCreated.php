<?php

namespace App\Events;

use App\Account\Account;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AccountCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Account
     */
    public $account;

    /**
     * Create a new event instance.
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        //
        $this->account = $account;
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
