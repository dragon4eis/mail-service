<?php


namespace App\Classes\Mailers;


trait ConstructMailBody
{
    public function constructBody(array $from, array $to, string $subject, string $contentType, string $message){
        $this->setSender($from['address'], $from['name']);
        $this->setRecipients($to);
        $this->setSubject($subject);
        $this->setMessage($contentType, $message);
    }
}
