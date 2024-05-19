<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentRepository extends BaseRepository
{
    public string $sortBy = 'created_at';
    public string $sortOrder = 'desc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param Comment $model Repo DB ORM Model
     */
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $postId
     * @param int $itemsPerPage
     * @param string|null $sortBy
     * @param string|null $orderBy
     * @return LengthAwarePaginator
     */
    public function getFilteredWithPaginate(
        string $postId, int $itemsPerPage = -1, string $sortBy = null, string $orderBy = null): LengthAwarePaginator
    {
        $query = $this->model->where('post_id', $postId)->whereNull('parent_id');

        if ($sortBy && $orderBy) {
            $query->orderBy($sortBy, $orderBy);
        }
        $comments = $query->orderBy($this->sortBy, $this->sortOrder)->get();

        $nestedComments = $comments->map(function ($comment) use ($sortBy, $orderBy) {
            $comment->replies = $this->getNestedReplies($comment->id, $sortBy, $orderBy);
            return $comment;
        });

        $nestedComments = $nestedComments->values();

        if ($itemsPerPage === -1) {
            $itemsPerPage = $nestedComments->count();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $nestedComments->slice(($currentPage - 1) * $itemsPerPage, $itemsPerPage);

        return new LengthAwarePaginator($currentPageItems, $nestedComments->count(), $itemsPerPage, $currentPage);
    }

    /**
     * @param string $parentId
     * @param string|null $sortBy
     * @param string|null $orderBy
     * @return mixed
     */
    private function getNestedReplies(string $parentId, string $sortBy = null, string $orderBy = null): mixed
    {
        $query = $this->model->where('parent_id', $parentId);

        if ($sortBy && $orderBy) {
            $query->orderBy($sortBy, $orderBy);
        }
        $replies = $query->orderBy($this->sortBy, $this->sortOrder)->get();

        return $replies->map(function ($reply) use ($sortBy, $orderBy) {
            $reply->replies = $this->getNestedReplies($reply->id, $sortBy, $orderBy);
            return $reply;
        });
    }
}
