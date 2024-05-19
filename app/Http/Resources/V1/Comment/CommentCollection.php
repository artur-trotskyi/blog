<?php

namespace App\Http\Resources\V1\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{
    public static $wrap = null;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $transformedComments = [];
        foreach ($this->collection['comments'] as $comments) {
            foreach ($comments as $comment) {
                $transformedComments[] = new CommentResource($comment);
            }
        }

        return [
            'comments' => $transformedComments,
            'totalPages' => $this->collection['totalPages']->resource,
            'totalComments' => $this->collection['totalComments']->resource,
            'page' => $this->collection['page']->resource,
        ];
    }
}
