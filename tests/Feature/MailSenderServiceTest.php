<?php

namespace Tests\Feature;

use App\Classes\Mailers\EmailContent;
use App\Classes\Mailers\MailServiceFactory;
use App\Classes\Mailers\SendEmail;
use App\Models\EmailMessage;
use App\Repositories\Database\EmailMessageRepository;
use App\Services\EmailMessageService;
use App\Services\MailSenderService;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class MailSenderServiceTest extends TestCase
{
    protected $mailSender;

    protected $emailService;

    protected $inputs;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSendMessageUsingMajJet()
    {
        $emailMessage = $this->emailService->makeItem($this->inputs);

        $this->assertInstanceOf(
            Model::class,
            $emailMessage
        );

        $this->assertTrue(
            $this->mailSender->withMailService(MailServiceFactory::MAIL_JET_MAIL_SERVICE)->sendMail($emailMessage)
        );
    }

    public function testSendMessageUsingSendGrid()
    {
        $emailMessage = $this->emailService->makeItem($this->inputs);

        $this->assertInstanceOf(
            Model::class,
            $emailMessage
        );

        $this->assertTrue(
            $this->mailSender->withMailService(MailServiceFactory::SEND_GRID_MAIL_SERVICE)->sendMail($emailMessage)
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->mailSender = new MailSenderService();
        $this->emailService = new EmailMessageService(new EmailMessageRepository(new EmailMessage()));
        $this->inputs = [
            'subject' => 'test subject',
            'type' => EmailContent::MAIL_FORMAT_TEXT,
            'message' => Factory::create()->realText(),
            'recipients' => [
                [
                    'address' => 'stev56@abv.bg'
                ]
            ]
        ];
    }
}
