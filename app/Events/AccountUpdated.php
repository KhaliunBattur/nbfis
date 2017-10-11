<?php

namespace App\Events;

use App\Account\Account;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AccountUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Account
     */
    public $account;

    /**
     * @var Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param Account $account
     * @param Request $request
     */
    public function __construct(Account $account, Request $request)
    {
        //
        $this->account = $account;
        $this->request = $request;
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
