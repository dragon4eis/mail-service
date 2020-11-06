<?php

namespace Tests\Unit;

use App\Classes\Mailers\EmailContent;
use App\Classes\Mailers\MailServiceFactory;
use App\Classes\Mailers\SendGrid\ContentTypes\SendGridEmailContent;
use App\Classes\Mailers\SendGrid\SendGridSender;
use Tests\TestCase;

class SendGridTest extends TestCase
{
    private SendGridSender $senderService;
    private array $sender;
    private array $recipients;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSendgridSender()
    {
        $isMailSend = $this->senderService
            ->setMail($this->sender, $this->recipients, 'Test', new SendGridEmailContent(EmailContent::MAIL_FORMAT_TEXT, "test"))
            ->send();
        $this->assertTrue($isMailSend);
    }

    public function testSendGridContentTypes(){
        $this->assertSame("text/html",  (new SendGridEmailContent(EmailContent::MAIL_FORMAT_HTML, ''))->getTypeAsText());
        $this->assertSame("text/html",  (new SendGridEmailContent(EmailContent::MAIL_FORMAT_MARKDOWN, ''))->getTypeAsText());
        $this->assertSame("text/plain",  (new SendGridEmailContent(EmailContent::MAIL_FORMAT_TEXT, ''))->getTypeAsText());
    }

    public function testSendGridHTMLMail(){
        $mailService = MailServiceFactory::getService(MailServiceFactory::SEND_GRID_MAIL_SERVICE);
        $this->assertTrue($mailService->sendEmail(
            $this->sender,
            $this->recipients,
            'html message',
            EmailContent::MAIL_FORMAT_HTML,
            '<h3>Test title</h3><ul><li>list item 1</li><li>list item 2</li></ul>'
        ));
    }

    public function testSendGridMarkDownMail(){
        $mailService = MailServiceFactory::getService(MailServiceFactory::SEND_GRID_MAIL_SERVICE);
        $this->assertTrue($mailService->sendEmail(
            $this->sender,
            $this->recipients,
            'html message',
            EmailContent::MAIL_FORMAT_MARKDOWN,
            "# Test list:\n - list item 1\n - list item 2\n"
        ));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->senderService = new SendGridSender();
        $this->sender = [
            'name' => config('mail.from.name'),
            'address' => config('mail.from.address')
        ];
        $this->recipients = [
            [
                'email' => "stev56@abv.bg",
                'name' => "Example User"
            ]
        ];
    }
}
