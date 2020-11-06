<?php


namespace App\Classes\Mailers\MailJet\ContentTypes;


use App\Classes\Mailers\Message;
use App\Classes\Mailers\Parsers\MarkdownToHtmlParser;
use App\Classes\Mailers\Parsers\Parser;

class MarkdownContent extends Message
{
    protected Parser $parser;
    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->parser = new MarkdownToHtmlParser();
    }

    public function getMessageType(): string
    {
        return "HTMLPart";
    }

    public function getMessage(): string
    {
        return $this->parser->reFormat(parent::getMessage());
    }
}
