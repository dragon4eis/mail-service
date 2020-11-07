<?php


namespace App\Services;


use App\Repositories\EmailLogRepositoryInterface;

class EmailLogService extends BaseRepositoryService implements EmailLogServiceInterface
{
    public function __construct(EmailLogRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}