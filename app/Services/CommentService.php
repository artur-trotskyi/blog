<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Cache;

class CommentService extends BaseService
{
    public function __construct
    (
        CommentRepository $repo
    )
    {
        $this->repo = $repo;
    }

    /**
     * @param string $postId
     * @param int $itemsPerPage
     * @param string|null $sortBy
     * @param string|null $orderBy
     * @return array
     */
    public function filter(string $postId, int $itemsPerPage, string|null $sortBy, string|null $orderBy): array
    {
        $cacheTag = config('cache.tags.comments');
        $cacheKey = "postId={$postId}&itemsPerPage={$itemsPerPage}&sortBy={$sortBy}&orderBy={$orderBy}";
        $comments = Cache::tags($cacheTag)->remember($cacheKey, config('cache.ttl'), function () use ($postId, $itemsPerPage, $sortBy, $orderBy) {
            return $this->repo->getFilteredWithPaginate($postId, $itemsPerPage, $sortBy, $orderBy);
        });

        return [
            'comments' => $comments->items(),
            'totalPages' => $comments->lastPage(),
            'totalComments' => $comments->total(),
            'page' => $comments->currentPage()
        ];
    }
}
