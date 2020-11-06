<?php


namespace App\Classes\Mailers\SendGrid\ContentTypes;


use App\Classes\Mailers\Message;

final class TextContent extends Message
{
    protected const TYPE = "text/plain";

    public function getMessageType(): string
    {
        return "text/plain";
    }
}
