<?php

namespace App\Listeners;

use App\Events\EmailFailed;
use App\Interfaces\EmailLogging;
use App\Services\EmailLogServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFailure
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
     * @param  EmailFailed  $event
     * @return void
     */
    public function handle(EmailFailed $event)
    {
        $this->logger->makeItem([
            'recourse' => get_class($event->emailMessage),
            'operation' => EmailLogging::FAILED_TO_SEND_OPERATION,
            'email_message_id' => $event->emailMessage->id,
            'description' => 'Email sending failed'
        ]);
    }
}
