<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseInterface
{
    public string $sortBy = 'created_at';
    public string $sortOrder = 'asc';
    protected Model $model;

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param Model $model Repo DB ORM Model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all instances of model.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();
    }

    /**
     * Get all instances of model with trashed.
     *
     * @return Collection
     */
    public function allWithTrashed(): Collection
    {
        return $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->withTrashed()
            ->get();
    }

    /**
     * Create a new record in the database.
     *
     * @param array $data
     * @return model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Show the record with the given id.
     *
     * @param string $id
     * @return Model|null
     */
    public function findById(string $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Update record in the database and get data back.
     *
     * @param string $id
     * @param array $data
     * @return bool
     */
    public function update(string $id, array $data): bool
    {
        try {
            $query = $this->model->where('id', $id);
            return (bool)$query->update($data);

        } catch (ModelNotFoundException|Exception $e) {
            return false;
        }
    }

    /**
     * Update or create a record in the database.
     *
     * @param array $where The conditions to search for existing records.
     * @param array $data The data to update or create the record with.
     * @return Model
     */
    public function updateOrCreate(array $where, array $data): Model
    {
        return $this->model->updateOrCreate($where, $data);
    }

    /**
     * Remove record from the database.
     *
     * @param string $id
     * @return bool
     */
    public function destroy(string $id): bool
    {
        return (bool)$this->model->destroy($id);
    }

    /**
     * Get count of model.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }
}
