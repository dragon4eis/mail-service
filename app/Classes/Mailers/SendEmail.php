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
     * @param string $contentType
     * @param string $message
     *
     * @return mixed
     */
    public function sendEmail(array $from, array $recipients, string $subject, string $contentType, string $message): bool;
}
