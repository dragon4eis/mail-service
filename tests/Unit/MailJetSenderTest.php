<?php

namespace Tests\Unit;

use App\Classes\Mailers\EmailContentType;
use App\Classes\Mailers\MailJet\ContentTypes\MailJetEmailContentType;
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
        //create text mail known email address
        $isMailSend = $this->senderService
            ->setMail( $this->sender,  $this->recipients, 'Test', 'TextPart', "test")
            ->send();
        $this->assertTrue($isMailSend);
    }

    public function testMailJestContentTypes(){
        $this->assertSame('HTMLPart',  (new MailJetEmailContentType(EmailContentType::MAIL_FORMAT_HTML))->getTypeAsText());
        $this->assertSame('TextPart',  (new MailJetEmailContentType(EmailContentType::MAIL_FORMAT_TEXT))->getTypeAsText());
    }

    public function testMailJestHtmlMessage(){
        $mailService = MailServiceFactory::getService(MailServiceFactory::MAIL_JET_MAIL_SERVICE);
        $this->assertTrue($mailService->sendEmail(
            $this->sender,
            $this->recipients,
            'html message',
            EmailContentType::MAIL_FORMAT_HTML,
            '<h3>Test title</h3><ul><li>list item 1</li><li>list item 2</li></ul>'
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
                'email' => "stev56@abv.bg",
                'name' => "Example User"
            ]
        ];
    }
}
