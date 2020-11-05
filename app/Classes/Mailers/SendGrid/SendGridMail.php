<?php


namespace App\Classes\Mailers\SendGrid;


use App\Classes\Mailers\ConstructMailBody;
use App\Classes\Mailers\Mailable;
use Exception;
use SendGrid\Mail\Mail;
use SendGrid\Mail\TypeException;

final class SendGridMail implements Mailable
{
    use ConstructMailBody;
    private Mail $mail;

    /**
     * SendGridMail constructor.
     *
     * @param array  $from
     * @param array  $to
     * @param string $subject
     * @param string $contentType
     * @param string $message
     *
     * @throws TypeException
     */
    public function __construct(array $from, array $to, string $subject, string $contentType, string $message)
    {
        $this->mail = new Mail();
        $this->constructBody($from,$to,$subject, $contentType, $message);
    }

    public function getMail(){
        return $this->mail;
    }

    /**
     * Initialize sender address and name
     *
     * @param string $address
     * @param string $name
     *
     * @throws TypeException
     */
    public function setSender(string $address, string $name)
    {
        $this->mail->setFrom($address, $name);
    }

    /**
     * Initialize recipients
     *
     * @param array $recipients
     *
     * @throws Exception
     */
    public function setRecipients(array $recipients)
    {
        if (!count($recipients)) {
            throw new Exception("There must be at least one recipient");
        }
        //reformat recipients array
        $formattedArray = [];
        foreach ($recipients as $recipient) {
            $formattedArray[$recipient['email']] = $recipient['name'];
        }
        $this->mail->addTos($formattedArray);
    }

    /**
     * Set mail subject
     *
     * @param string $subject
     *
     * @throws TypeException
     */
    public function setSubject(string $subject)
    {
        $this->mail->setSubject($subject);
    }

    /**
     * Set mail message
     *
     * @param string $type
     * @param string $message
     *
     * @throws TypeException
     */
    public function setMessage(string $type, string  $message){
        $this->mail->addContent($type, $message);
    }
}
