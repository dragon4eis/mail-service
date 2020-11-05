<?php


namespace App\Classes\Mailers\MailJet;


use App\Classes\Mailers\MailJet\ContentTypes\MailJetEmailContentType;
use App\Classes\Mailers\SendEmail;

final class MailJetAdapter implements SendEmail
{
    protected MailJetSender $sender;

    public function __construct()
    {
        $this->sender = new MailJetSender();
    }

    public function sendEmail(array $from, array $recipients, string $subject, string $contentType, string $message): bool
    {
        $mailType = new MailJetEmailContentType($contentType);
        return $this->sender
            ->setMail($from, $recipients, $subject, $mailType->getTypeAsText(), $message)
            ->send();

    }

}
