<?php


namespace App\Repositories\Database;


use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BaseDatabaseRepository implements DatabaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function list(array $filters = [], array $oderBy = []): Collection
    {
        return $this->model
            //apply search filter or additional filters
            ->where(function ($query) use ($filters) {
                if ($filters) {
                    foreach ($filters as $column => $value) {
                        $query->where($column, '=', $value);
                    }
                }
            })
            // order elements by given orderBy or sort by "from New to Old"
            ->when($oderBy, function ($query) use ($oderBy) {
                foreach ($oderBy as $column => $direction)
                    $query->orderBy($column, $direction);
            }, function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->get();
    }

    public function makeNew(array $attributes): Model
    {
        $this->model->fill($attributes);
        throw_if(!$this->model->save(), new Exception("Model was not saved!"));
        return $this->model;
    }

    public function change($id, array $attributes): Model
    {
        $element = $this->load($id);
        $element->update($attributes);
        return $element;
    }

    public function load($id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    public function delete(array $ids): bool
    {
        return $this->model->destroy($ids);
    }
}