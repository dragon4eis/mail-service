<?php

namespace Tests\Unit;

use App\Classes\Mailers\SendGrid\SendGridSender;
use Tests\TestCase;

class SendGridTest extends TestCase
{
    private $sender;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $sender = [
            'name' =>  config('mail.from.name'),
            'address' => config('mail.from.address')
        ];
        $to = [
           [
               'email' => "test@example.com",
               'name' => "Example User"
           ]
        ];
        $isMailSend = $this->sender
            ->setMail($sender, $to, 'Test', 'text/plain', "test")
            ->send();
        $this->assertTrue($isMailSend);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->sender = new SendGridSender();
    }
}
