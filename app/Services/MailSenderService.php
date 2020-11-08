<?php


namespace App\Services;


use App\Classes\Mailers\MailServiceFactory;
use App\Classes\Mailers\SendEmail;
use App\Events\EmailSend;
use App\Exceptions\EmailMessageNotSend;
use App\Models\EmailMessage;
use Exception;
use Illuminate\Support\Facades\Log;

final class MailSenderService implements MailSenderInterface
{
    protected SendEmail $sender;

    public function withMailService(int $service): MailSenderInterface
    {
        $this->sender = MailServiceFactory::getService($service);
        return $this;
    }

    public function sendMail(EmailMessage $emailMessage): bool
    {

        $mailIsSend = $this->sender->sendEmail(
            $emailMessage->from,
            $emailMessage->recipients->toArray(),
            $emailMessage->subject,
            $emailMessage->type,
            $emailMessage->message
        );
        if($mailIsSend) {
            EmailSend::dispatch($emailMessage);
            return true;
        } else {
            throw new EmailMessageNotSend();
        }
    }

    /**
     * Returns the index for the fallback service
     *
     * @param int $attempts
     *
     * @return int
     */
    public function getFallBackService(int $attempts): int
    {
        $mailers = $this->getSupportedMailers();

        //to get the fallback option we need the failures at are one less the attempts
        return $this->getSupportedMailers()[abs($attempts - 1) % sizeof($mailers)];
    }

    /**
     * Gets the supported mailing service for the service factory
     *
     * @return array
     */
    public function getSupportedMailers(): array
    {
        return MailServiceFactory::getEnabledSenders();
    }
}