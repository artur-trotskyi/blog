<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Support\Str;

class PostService extends BaseService
{
    public function __construct
    (
        PostRepository $repo
    )
    {
        $this->repo = $repo;
    }

    /**
     * @param int $itemsPerPage
     * @param int $page
     * @param string|null $sortBy
     * @param string|null $orderBy
     * @return array
     */
    public function filter(int $itemsPerPage, int $page, string|null $sortBy, string|null $orderBy): array
    {
        $posts = $this->repo->getFilteredWithPaginate($itemsPerPage, $page, $sortBy, $orderBy);

        return [
            'posts' => $posts->items(),
            'totalPages' => $posts->lastPage(),
            'totalPosts' => $posts->total(),
            'page' => $posts->currentPage()
        ];
    }

    /**
     * @param string $text
     * @param int $limit
     * @return string
     */
    public function createSlug(string $text, int $limit = 100): string
    {
        $attempt = 1;

        do {
            $slug = Str::limit(Str::slug($text), $limit - strlen((string)$attempt), '');
            $slug .= $attempt > 1 ? $attempt : '';
            $existingSlug = $this->repo->isSlugExist($slug);
            $attempt++;
        } while ($existingSlug);

        return $slug;
    }
}
