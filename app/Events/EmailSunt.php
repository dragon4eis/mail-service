<?php

namespace App\Events;

use App\Models\EmailMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailSunt
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public EmailMessage $emailMessage;

    /**
     * Create a new event instance.
     *
     * @param EmailMessage $email
     */
    public function __construct(EmailMessage $email)
    {
        $this->emailMessage = $email;
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
