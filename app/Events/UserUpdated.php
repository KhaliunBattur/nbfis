<?php

namespace App\Events;

use App\User\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var User
     */
    public $user;
    public $text;
    public $type;

    /**
     * Create a new event instance.
     * @param User $user
     * @param $text
     * @param $type
     */
    public function __construct(User $user, $text, $type)
    {
        //
        $this->user = $user;
        $this->text = $text;
        $this->type = $type;
    }
}
