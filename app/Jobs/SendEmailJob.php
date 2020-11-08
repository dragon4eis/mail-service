<?php

namespace App\Jobs;

use App\Events\EmailFailed;
use App\Events\EmailProcessing;
use App\Models\EmailMessage;
use App\Services\MailSenderInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Throwable;

final class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $emailMessage;

    /**
     * Create a new job instance.
     *
     * @param EmailMessage        $emailMessage
     */
    public function __construct(EmailMessage $emailMessage)
    {
        $this->emailMessage = $emailMessage;
        EmailProcessing::dispatch($emailMessage);
    }

    /**
     * Execute the job.
     *
     * @param MailSenderInterface $service
     *
     * @return void
     */
    public function handle(MailSenderInterface $service)
    {
        //try to send email
        $service
            ->withMailService($service->getFallBackService($this->attempts() - 1))
            ->sendMail($this->emailMessage);
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        //lock the recourse
        return [(new WithoutOverlapping($this->emailMessage->id))->dontRelease()];
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        EmailFailed::dispatch($this->emailMessage);
    }
}
