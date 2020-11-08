<?php


namespace App\Services;


use App\Models\EmailMessage;

interface MailSenderInterface
{
    public function withMailService(int $service): MailSenderInterface;

    public function sendMail(EmailMessage $emailMessage): bool;

    public function getSupportedMailers(): array;

    public function getFallBackService(int $attempts): int;
}