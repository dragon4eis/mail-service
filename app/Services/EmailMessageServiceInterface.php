<?php


namespace App\Services;


interface EmailMessageServiceInterface extends RepositoryServiceInterface
{
    public function reformatInputs(array $inputArray): array;
}