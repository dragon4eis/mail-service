<?php


namespace App\Classes\Mailers\MailJet;


use Illuminate\Support\Facades\Log;
use Mailjet\Client;
use Mailjet\Resources;

final class MailJetSender
{
    protected array $mails;
    private $mailJet;

    public function __construct()
    {
        $this->mailJet = new Client(config('mail.automated_providers.mailjet.public_api_key'), config('mail.automated_providers.mailjet.private_api_key'),true,['version' => 'v3.1']);
    }


    /**
     * @param array  $from
     * @param array  $to
     * @param string $subject
     * @param string $contentType
     * @param string $message
     *
     * @return MailJetSender
     * @throws \SendGrid\Mail\TypeException
     */
    public function setMail(array $from, array $to, string $subject, string $contentType, string $message){
        $this->mails[] = (new MailJetMail($from, $to, $subject, $contentType, $message))->getMail();
        return $this;
    }

    /**
     * @return bool
     */
    public function send(): bool{
        try {
            $response = $this->mailJet->post(Resources::$Email, ['body' => ['Messages' => $this->mails] ]);
            return $response->success();
        } catch (\Exception $exception){
            Log::critical($exception);
            return false;
        }
    }
}
