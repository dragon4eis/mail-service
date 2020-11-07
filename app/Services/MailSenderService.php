<?php


namespace App\Services;


use App\Classes\Mailers\MailServiceFactory;

use App\Classes\Mailers\SendEmail;
use App\Models\EmailMessage;

final class MailSenderService implements MailSenderInterface
{
    protected SendEmail $sender;

    public function withMailService(int $service): MailSenderInterface
    {
        $this->sender = MailServiceFactory::getService($service);
        return  $this;
    }

    public function sendMail(EmailMessage $emailMessage): bool
    {
        throw_if(
            !$this->sender->sendEmail(
                $emailMessage->from,
                $emailMessage->recipients->toArray(),
                $emailMessage->subject,
                $emailMessage->type,
                $emailMessage->message
            ),
            new \Exception("Email was not send")
        );
        return true;
    }

    public function getSupportedMailers(): array
    {
       return [
            'SendGrid' =>   MailServiceFactory::SEND_GRID_MAIL_SERVICE,
            'MailJet' => MailServiceFactory::MAIL_JET_MAIL_SERVICE
       ];
    }
}