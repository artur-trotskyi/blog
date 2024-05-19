<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository extends BaseRepository
{
    public string $sortBy = 'created_at';
    public string $sortOrder = 'desc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param Post $model Repo DB ORM Model
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $itemsPerPage
     * @param int $page
     * @param string|null $sortBy
     * @param string|null $orderBy
     * @return LengthAwarePaginator
     */
    public function getFilteredWithPaginate(
        int $itemsPerPage = -1, int $page = 1, string $sortBy = null, string $orderBy = null): LengthAwarePaginator
    {
        $query = $this->model;

        if ($sortBy && $orderBy) {
            $query->orderBy($sortBy, $orderBy);
        }
        $query->orderBy($this->sortBy, $this->sortOrder);

        if ($itemsPerPage === -1) {
            $itemsPerPage = $query->count();
        }

        return $query->paginate($itemsPerPage, ['*'], 'page', $page);
    }

    /**
     * @param string $slug
     * @return bool
     */
    public function isSlugExist(string $slug): bool
    {
        return $this->model->where('slug', $slug)->exists();
    }
}
