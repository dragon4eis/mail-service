<?php


namespace App\Classes\Mailers\SendGrid\ContentTypes;


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
        return "text/html";
    }

    public function getMessage(): string
    {
        return $this->parser->reFormat(parent::getMessage());
    }
}
