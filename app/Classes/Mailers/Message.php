<?php


namespace App\Classes\Mailers;


abstract class Message
{
    protected  string  $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Return Message type
     * @return string
     */
    abstract public function getMessageType(): string;

    /**
     * Returns message;
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }
}
