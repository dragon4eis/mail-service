<?php


namespace App\Classes\Mailers\SendGrid\ContentTypes;


use App\Classes\Mailers\MessageType;

class TextContentType extends MessageType
{
    protected const TYPE = "text/plain";

    public function getMessageType(): string
    {
        return "text/plain";
    }
}
