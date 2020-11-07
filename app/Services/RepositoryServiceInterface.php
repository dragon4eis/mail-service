<?php


namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryServiceInterface
{
    /**
     * Lists Items
     *
     * @param array $filter
     * @param array $sort
     *
     * @return Collection
     */
    public function listItems(array $filter = [], array $sort = []): Collection;

    /**
     * @param array $inputs
     *
     * @return Model
     */
    public function makeItem(array $inputs): ?Model;

    /**
     * @param array $inputs
     *
     * @return Model|null
     */
    public function editItem($id, array $inputs): ?Model;

    /**
     * @param $id
     *
     * @return Model|null
     */
    public function findItem($id): ?Model;

    /**
     * @param array $ids
     *
     * @return bool
     */
    public function remove(array $ids): bool;
}