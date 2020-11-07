<?php

namespace Tests\Feature;

use App\Jobs\SendEmailJob;
use App\Models\EmailMessage;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QueueTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testEmailSenderQueue()
    {
        $emailMessage = EmailMessage::first();

        Queue::fake();

        Queue::assertNothingPushed();

        SendEmailJob::dispatch($emailMessage);

        Queue::assertPushed(function (SendEmailJob $sendEmail) use ($emailMessage) {
            return $sendEmail->emailMessage->id === $emailMessage->id;
        });
    }
}
