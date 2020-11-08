<?php

namespace Tests\Unit;

use App\Classes\Mailers\EmailContent;
use App\Classes\Mailers\MailJet\ContentTypes\MailJetEmailContent;
use App\Classes\Mailers\MailJet\MailJetSender;
use App\Classes\Mailers\MailServiceFactory;
use Tests\TestCase;

class MailJetSenderTest extends TestCase
{
    private MailJetSender $senderService;
    private array $sender;
    private array $recipients;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testMailJetSender()
    {
        $isMailSend = $this->senderService
            ->setMail( $this->sender,  $this->recipients, 'Test', new MailJetEmailContent(EmailContent::MAIL_FORMAT_TEXT, "test"))
            ->send();
        $this->assertTrue($isMailSend);
    }

    public function testMailJestContentTypes(){
        $this->assertSame('HTMLPart',  (new MailJetEmailContent(EmailContent::MAIL_FORMAT_HTML, ""))->getTypeAsText());
        $this->assertSame('HTMLPart',  (new MailJetEmailContent(EmailContent::MAIL_FORMAT_MARKDOWN, ""))->getTypeAsText());
        $this->assertSame('TextPart',  (new MailJetEmailContent(EmailContent::MAIL_FORMAT_TEXT, ""))->getTypeAsText());
    }

    public function testMailJestHtmlMessage(){
        $mailService = MailServiceFactory::getService(MailServiceFactory::MAIL_JET_MAIL_SERVICE);
        $this->assertTrue($mailService->sendEmail(
            $this->sender,
            $this->recipients,
            'html message',
            EmailContent::MAIL_FORMAT_HTML,
            '<h3>Test title</h3><ul><li>list item 1</li><li>list item 2</li></ul>'
        ));
    }

    public function testMailJetMarkDownMail(){
        $mailService = MailServiceFactory::getService(MailServiceFactory::MAIL_JET_MAIL_SERVICE);
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
        $this->senderService = new MailJetSender();
        $this->sender = [
            'name' => config('mail.from.name'),
            'address' => config('mail.from.address')
        ];
        $this->recipients = [
            [
                'address' => config('mail.mail_for_tests'),
                'name' => "Example User"
            ]
        ];
    }
}
