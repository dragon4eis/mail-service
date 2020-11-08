<?php

namespace Tests\Feature;

use App\Classes\Mailers\EmailContent;
use App\Events\EmailCreate;
use App\Events\EmailFailed;
use App\Events\EmailProcessing;
use App\Events\EmailSend;
use App\Models\EmailMessage;
use App\Repositories\Database\EmailMessageRepository;
use App\Services\EmailMessageService;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class EmailLogTest extends TestCase
{
    protected $service;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEventLogCreate()
    {
        //set inputs
        $inputs = [
            'subject' => 'test subject',
            'type' => EmailContent::MAIL_FORMAT_TEXT,
            'message' => Factory::create()->realText(),
            'recipients' => [
                [
                    'address' => config('mail.mail_for_tests')
                ]
            ]
        ];
        $email = $this->service->makeItem($inputs);

        //test if the event was send
        Event::assertDispatched(function (EmailCreate $event) use ($email) {
            return $event->emailMessage->id === $email->id;
        });

        //assert if email in in te queue
        Event::assertDispatched(function (EmailProcessing $event) use ($email) {
            return $event->emailMessage->id === $email->id;
        });

        //email cannot be failed because  because que in not executed
        Event::assertNotDispatched(EmailFailed::class);

        //email cannot be succeeds because was not sent
        Event::assertNotDispatched(EmailSend::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new  EmailMessageService(new EmailMessageRepository(new EmailMessage()));
        Event::fake();
        Queue::fake();
    }
}
