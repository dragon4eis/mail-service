<?php

namespace App\Listeners;

use App\Events\EmailProcessing;
use App\Interfaces\EmailLogging;
use App\Services\EmailLogServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

final class LogProcessing
{
    private EmailLogServiceInterface $logger;

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
     * @param  EmailProcessing  $event
     * @return void
     */
    public function handle(EmailProcessing $event)
    {
        $event->emailMessage->setInQueueStatus();
        $this->logger->makeItem([
            'recourse' => get_class($event->emailMessage),
            'operation' => EmailLogging::PROCESSING_EMAIL_OPERATION,
            'email_message_id' => $event->emailMessage->id,
            'description' => 'Email message was send to processing queue'
        ]);
    }
}
