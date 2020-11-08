<?php

namespace Tests\Feature;

use App\Classes\Mailers\Parsers\MarkdownToHtmlParser;
use Tests\TestCase;

class MarkdownTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMarkDownParser()
    {
        $markdownText = "# Test list:\n - list item 1\n - list item 2\n";

        $parsedText = (new MarkdownToHtmlParser())->reFormat($markdownText);

        $this->assertSame($parsedText, "<h1>Test list:</h1>\n<ul>\n<li>list item 1</li>\n<li>list item 2</li>\n</ul>");
    }
}
