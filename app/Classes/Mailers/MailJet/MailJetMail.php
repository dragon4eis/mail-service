<?php


namespace App\Classes\Mailers\MailJet;


use App\Classes\Mailers\ConstructMailBody;
use App\Classes\Mailers\EmailContent;
use App\Classes\Mailers\Mailable;
use Exception;

final class MailJetMail implements Mailable
{
    use ConstructMailBody;
    private array $mail;

    public function __construct(array $from, array $to, string $subject, EmailContent $emailContent)
    {
        $this->constructBody($from,$to,$subject, $emailContent);
    }

    public function getMail()
    {
        return $this->mail;

    }

    public function setSender(string $address, string $name)
    {
        $this->mail['From'] = [
            'Name' => $name,
            'Email' => $address
        ];
    }

    /**
     * @param array $recipients
     *
     * @throws Exception
     */
    public function setRecipients(array $recipients)
    {
        if (!count($recipients)) {
            throw new Exception("There must be at least one recipient");
        }
        foreach ($recipients as $recipient) {
            $this->mail['To'][] = [
                'Name' => $recipient['name'],
                'Email' => $recipient['address']
            ];
        }
    }

    public function setSubject(string $subject)
    {
        $this->mail['Subject'] = $subject;
    }

    public function setMessage(EmailContent $emailContent)
    {
        $this->mail[$emailContent->getTypeAsText()] = $emailContent->getMessageText();
    }
}
