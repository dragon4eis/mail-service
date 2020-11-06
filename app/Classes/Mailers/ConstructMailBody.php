<?php


namespace App\Classes\Mailers;


trait ConstructMailBody
{
    public function constructBody(array $from, array $to, string $subject, EmailContent $emailContent){
        $this->setSender($from['address'], $from['name']);
        $this->setRecipients($to);
        $this->setSubject($subject);
        $this->setMessage($emailContent);
    }
}
