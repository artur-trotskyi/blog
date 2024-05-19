<?php

namespace App\Http\Resources\V1\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    public static $wrap = null;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $transformedPosts = [];
        foreach ($this->collection['posts'] as $posts) {
            foreach ($posts as $post) {
                $transformedPosts[] = new PostResource($post);
            }
        }

        return [
            'posts' => $transformedPosts,
            'totalPages' => $this->collection['totalPages']->resource,
            'totalPosts' => $this->collection['totalPosts']->resource,
            'page' => $this->collection['page']->resource,
        ];
    }
}
