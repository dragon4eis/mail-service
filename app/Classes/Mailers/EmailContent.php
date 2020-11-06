<?php


namespace App\Classes\Mailers;


interface EmailContent
{
    const MAIL_FORMAT_TEXT = "text";
    const MAIL_FORMAT_HTML = "html";
    const MAIL_FORMAT_MARKDOWN = "markdown";

    public function getTypeAsText(): string;

    public function getMessageText(): string;
}
