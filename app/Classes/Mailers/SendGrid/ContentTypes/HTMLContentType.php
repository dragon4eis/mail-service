<?php


namespace App\Classes\Mailers\SendGrid\ContentTypes;


use App\Classes\Mailers\MessageType;

final class HTMLContentType extends MessageType
{
    public function getMessageType(): string
    {
       return  "text/html";
    }
}
