<?php

namespace App\Listeners;

use App\Events\EmailCreate;
use App\Interfaces\EmailLogging;
use App\Services\EmailLogServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogCreationOperation
{
    public $logger;

    /**
     * Create the event listener.
     *
     * @param EmailLogServiceInterface $logger
     */
    public function __construct(EmailLogServiceInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle the event.
     *
     * @param  EmailCreate  $event
     * @return void
     */
    public function handle(EmailCreate $event)
    {
        $this->logger->makeItem([
            'recourse' => get_class($event->emailMessage),
            'operation' => EmailLogging::CREATE_OPERATION,
            'email_message_id' => $event->emailMessage->id,
            'description' => 'Email was created :' . json_encode($event->emailMessage, true)
        ]);
    }
}
