<?php


namespace App\Classes\Mailers\MailJet\ContentTypes;


use App\Classes\Mailers\Message;

final class TextContent extends Message
{
    public function getMessageType(): string
    {
       return "TextPart";
    }
}
