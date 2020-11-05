<?php


namespace App\Classes\Mailers;


interface EmailContentType
{
    const MAIL_FORMAT_TEXT = "text";
    const MAIL_FORMAT_HTML = "html";

    public function getTypeAsText(): string;
}
