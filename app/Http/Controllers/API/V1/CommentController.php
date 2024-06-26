<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentIndexRequest;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\V1\Comment\CommentCollection;
use App\Http\Resources\V1\Comment\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private CommentService $commentService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct
    (
        CommentService $commentService
    )
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CommentIndexRequest $request): CommentCollection
    {
        $postId = $request->validated('postId');
        $itemsPerPage = $request->validated('itemsPerPage');
        $sortBy = $request->validated('sortBy');
        $orderBy = $request->validated('orderBy');

        $comments = $this->commentService->filter($postId, $itemsPerPage, $sortBy, $orderBy);

        return new CommentCollection($comments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param CommentStoreRequest $request
     * @return CommentResource
     */
    public function store(CommentStoreRequest $request): CommentResource
    {
        $postId = $request->validated('postId');
        $parentCommentId = $request->validated('parentCommentId');
        $massage = $request->validated('text');

        $newComment = $this->commentService->create([
            'post_id' => $postId,
            'parent_id' => $parentCommentId,
            'user_id' => auth()->id(),
            'message' => $massage,
        ]);

        return new CommentResource($newComment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
