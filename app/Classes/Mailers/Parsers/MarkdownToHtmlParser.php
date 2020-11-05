<?php


namespace App\Classes\Mailers\Parsers;


use Parsedown;

class MarkdownToHtmlParser extends Parser
{
    public const TYPE = "MARKDOWN";
    private $parser;

    public function __construct()
    {
        $this->parser = new Parsedown();
    }

    public function reFormat(string $message): string
    {
       $this->parser->setSafeMode(true);
       return $this->parser->text($message);
    }
}
