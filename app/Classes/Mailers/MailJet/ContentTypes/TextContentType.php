<?php


namespace App\Classes\Mailers\MailJet\ContentTypes;


use App\Classes\Mailers\MessageType;

final class TextContentType extends MessageType
{
    public function getMessageType(): string
    {
       return "TextPart";
    }
}
