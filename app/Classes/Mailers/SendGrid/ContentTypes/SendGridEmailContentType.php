<?php


namespace App\Classes\Mailers\SendGrid\ContentTypes;


use App\Classes\Mailers\EmailContentType;
use Exception;

final class SendGridEmailContentType implements EmailContentType
{
    private $type;

    public function __construct(string $mail_type)
    {
        switch ($mail_type) {
            case self::MAIL_FORMAT_TEXT:
                $this->type = new TextContentType();
                break;
            case self::MAIL_FORMAT_HTML:
                $this->type = new HTMLContentType();
                break;
            default:
                throw new Exception("Unsupported mail format $mail_type");
        }
    }

    public function getTypeAsText(): string
    {
        return $this->type->getMessageType();
    }
}
