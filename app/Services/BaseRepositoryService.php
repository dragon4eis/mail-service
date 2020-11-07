<?php


namespace App\Services;


use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepositoryService implements RepositoryServiceInterface
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function listItems(array $filter = [], array $sort = []): Collection
    {
        return $this->repository->list($filter, $sort);
    }

    public function makeItem(array $inputs): ?Model
    {
       return $this->repository->makeNew($inputs);
    }

    public function editItem($id, array $inputs): ?Model
    {
       return $this->repository->change($id, $inputs);
    }

    public function findItem($id): ?Model
    {
       return $this->repository->load($id);
    }

    public function remove(array $ids): bool
    {
       return $this->repository->delete($ids);
    }
}