<?php


namespace App\Classes\Mailers;


abstract class MessageType
{
   abstract public function getMessageType(): string;
}
