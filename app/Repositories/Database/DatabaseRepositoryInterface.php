<?php


namespace App\Repositories\Database;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DatabaseRepositoryInterface
{
    /**
     * List the required elements with option to apply additional filters
     *
     * @param array  $filters
     * @param array  $oderBy
     *
     * @return Collection
     */
    public function list(array $filters = [], array $oderBy = []): Collection;

    /**
     * Saves new element in database and returns it
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function makeNew(array $attributes): Model;

    /**
     * Changes existing element and returns it with the updated data
     *
     * @param int|string $id
     * @param array      $attributes
     *
     * @return Model
     */
    public function change($id, array $attributes): Model;

    /**
     * Load element by its id
     *
     * @param int|string $id
     *
     * @return Model|null
     */
    public function load($id): ?Model;

    /**
     * Removes multiple elements from database
     *
     * @param array $ids
     *
     * @return bool
     */
    public function delete(array $ids): bool;
}
