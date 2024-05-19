<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseService
{
    /**
     * Repository.
     *
     * @var
     */
    public $repo;

    /**
     * Get all data.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repo->all();
    }

    /**
     * Get all data with trashed.
     *
     * @return Collection
     */
    public function allWithTrashed(): Collection
    {
        return $this->repo->allWithTrashed();
    }

    /**
     * Create new record.
     *
     * @param array $data
     * @return model
     */
    public function create(array $data): Model
    {
        return $this->repo->create($data);
    }

    /**
     * Find record by id.
     *
     * @param string $id
     * @return Model|null
     */
    public function findById(string $id): ?Model
    {
        return $this->repo->findById($id);
    }

    /**
     * Update data.
     *
     * @param string $id
     * @param array $data
     * @return bool
     */
    public function update(string $id, array $data): bool
    {
        return (bool)$this->repo->update($id, $data);
    }

    /**
     * Update or create data.
     *
     * @param array $where
     * @param array $data
     * @return Model
     */
    public function updateOrCreate(array $where, array $data): Model
    {
        return $this->repo->updateOrCreate($where, $data);
    }

    /**
     * Delete record by id.
     *
     * @param string $id
     * @return bool
     */
    public function destroy(string $id): bool
    {
        return $this->repo->destroy($id);
    }

    /**
     * count records.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->repo->count();
    }
}
