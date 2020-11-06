<?php


namespace App\Classes\Mailers\SendGrid;


use App\Classes\Mailers\EmailContent;
use Illuminate\Support\Facades\Log;
use SendGrid;

final class SendGridSender
{
    protected $mail;
    private $sendGrid;

    public function __construct()
    {
        $this->sendGrid = new SendGrid(config('mail.automated_providers.sendgrid.api_key'));
    }

    /**\
     * Creates sendGridMAil message
     *
     * @param array        $from
     * @param array        $to
     * @param string       $subject
     * @param EmailContent $emailContent
     *
     * @return $this
     */
    public function setMail(array $from, array $to, string $subject, EmailContent $emailContent)
    {
        try {
            $this->mail = (new SendGridMail($from, $to, $subject, $emailContent))->getMail();
        } catch (\Exception $exception){
            Log::critical($exception);
        }
        return $this;
    }

    /**
     * Sends the mail
     *
     * @return bool
     */
    public function send(): bool
    {
        try {
            $response = $this->sendGrid->send($this->mail);
            if ($response->statusCode() !== 202) {
                Log::error($response->body());
            }
            return $response->statusCode() === 202;
        } catch (\Exception $exception) {
            Log::critical($exception);
            return false;
        }
    }
}
