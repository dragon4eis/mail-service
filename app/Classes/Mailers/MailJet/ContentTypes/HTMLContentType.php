<?php


namespace App\Classes\Mailers\MailJet\ContentTypes;


use App\Classes\Mailers\MessageType;

class HTMLContentType extends MessageType
{
    public function getMessageType(): string
    {
        return  "HTMLPart";
    }
}
