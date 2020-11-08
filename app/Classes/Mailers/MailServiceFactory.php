<?php


namespace App\Classes\Mailers;


use App\Classes\Mailers\MailJet\MailJetAdapter;
use App\Classes\Mailers\SendGrid\SendGridAdapter;

class MailServiceFactory
{
    const SEND_GRID_MAIL_SERVICE = 1;
    const MAIL_JET_MAIL_SERVICE = 2;

    public static function getService(int $mail_service): SendEmail{
        switch ($mail_service){
            case self::SEND_GRID_MAIL_SERVICE:{
                return new SendGridAdapter();
            }
            case self::MAIL_JET_MAIL_SERVICE: {
                return  new MailJetAdapter();
            }
        }
    }

    /**
     * Returns array of services that can be used for the fallback logic
     * @return int[]
     */
    public static function getEnabledSenders(){
        //changing constants order will determine service priority
        return [
            self::MAIL_JET_MAIL_SERVICE,
            self::SEND_GRID_MAIL_SERVICE
        ];
    }
}
