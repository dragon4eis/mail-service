<?php


namespace App\Services;


interface EmailMessageServiceInterface
{
    public function reformatInputs(array $inputArray): array;
}