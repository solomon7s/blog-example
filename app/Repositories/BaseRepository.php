<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{

    public function __construct(protected Model $model) { }


    /**
     *
     * Find model by primary key
     * @param string $id
     * @return Model|null
     */
    public function find(string $id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Creates a model object and store to database
     *
     * @param array $attributes array of fillable model attributes
     *
     * @return Model Created instance
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }


    /**
     * Update model instance with updated attributes
     *
     * @param Model $model
     * @param array $updatedAttributes
     * @return Model
     */
    public function update(Model $model, array $updatedAttributes): Model
    {
        return tap($model)->update($updatedAttributes);
    }


    /**
     *
     * Find and update model with updated attributes values
     *
     * @param string $id
     * @param array $updatedAttributes
     * @return Model
     */
    public function findAndUpdate(string $id, array $updatedAttributes): Model
    {
        $model = $this->find($id);
        $model->fill($updatedAttributes);
        $model->save();
        return $model;
    }


    /**
     * Retrieve all the records of model from database as Collection
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Delete model from database by primary key
     * @param string $id
     * @return bool|null
     */
    public function delete(string $id): bool
    {
        return (bool) $this->model->destroy($id);
    }


    /**
     * @param array $with
     * @param array $withCount
     * @return Builder
     */
    public function createQueryBuilder(array $with = [], array $withCount = []): Builder
    {
        $builder = $this->model::query();
        if ($with) {
            $builder->with($with);
        }

        if ($withCount) {
            $builder->withCount($withCount);
        }

        return $builder;
    }


}
