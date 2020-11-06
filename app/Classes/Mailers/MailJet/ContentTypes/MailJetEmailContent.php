<?php


namespace App\Classes\Mailers\MailJet\ContentTypes;


use App\Classes\Mailers\EmailContent;
use App\Classes\Mailers\ExtractMessage;

final class MailJetEmailContent implements EmailContent
{
    use ExtractMessage;

    private $type;

    /**
     * MailJetEmailContent constructor.
     *
     * @param string $mail_type
     * @param string $message
     *
     * @throws \Exception
     */
    public function __construct(string $mail_type, string $message)
    {
        switch ($mail_type) {
            case self::MAIL_FORMAT_TEXT:
                $this->type = new  TextContent($message);
                break;
            case self::MAIL_FORMAT_HTML:
                $this->type = new HTMLContent($message);
                break;
            case self::MAIL_FORMAT_MARKDOWN:
                $this->type = new MarkdownContent($message);
                break;
            default:
                throw new \Exception("Unsupported mail format $mail_type");
        }
    }

}
