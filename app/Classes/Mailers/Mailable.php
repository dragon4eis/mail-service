<?php


namespace App\Classes\Mailers;


use SendGrid\Mail\TypeException;

interface Mailable
{
    /**
     * Get constructed mail instance
     *
     * @return mixed
     */
    public function getMail();

    /**
     * Initialize sender address and name
     *
     * @param string $address
     * @param string $name
     *
     * @throws TypeException
     */
    public function setSender(string $address, string $name);

    /**
     * Initialize recipients
     *
     * @param array $recipients
     */
    public function setRecipients(array $recipients);

    /**
     * Set mail subject
     *
     * @param string $subject
     *
     * @throws TypeException
     */
    public function setSubject(string $subject);

    /**
     * Set mail message
     *
     * @param string $type
     * @param string $message
     *
     * @throws TypeException
     */
    public function setMessage(string $type, string  $message);
}
