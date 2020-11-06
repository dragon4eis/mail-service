<?php


namespace App\Classes\Mailers;


trait ExtractMessage
{
    public function getTypeAsText(): string
    {
        return $this->type->getMessageType();
    }

    public function getMessageText(): string
    {
        return  $this->type->getMessage();
    }
}
