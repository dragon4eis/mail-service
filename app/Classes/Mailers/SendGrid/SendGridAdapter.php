<?php


namespace App\Classes\Mailers\SendGrid;


use App\Classes\Mailers\SendEmail;
use App\Classes\Mailers\SendGrid\ContentTypes\SendGridEmailContent;

final class SendGridAdapter implements SendEmail
{
    protected  SendGridSender $sender;

    public function __construct()
    {
        $this->sender = new SendGridSender();
    }

    public function sendEmail(array $from, array $recipients, string $subject, string $contentType, string $message): bool
    {
        return $this->sender
            ->setMail($from, $recipients, $subject,  new SendGridEmailContent($contentType, $message))
            ->send();
    }
}
