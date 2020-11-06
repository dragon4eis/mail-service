<?php


namespace App\Classes\Mailers\SendGrid\ContentTypes;


use App\Classes\Mailers\Message;

final class HTMLContent extends Message
{
    public function getMessageType(): string
    {
       return  "text/html";
    }
}
