<?php


namespace App\Classes\Mailers;


interface SendEmail
{
    /**
     * Send email message to multiple recipients
     *
     * @param array  $from
     * @param array  $recipients
     * @param string $subject
     * @param string $message
     *
     * @return mixed
     */
    public function sendEmail(array $from, array $recipients, string $subject, string $message): bool;
}
