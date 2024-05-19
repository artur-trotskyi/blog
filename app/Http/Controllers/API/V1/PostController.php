<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostIndexRequest;
use App\Http\Resources\V1\Post\PostCollection;
use App\Http\Resources\V1\Post\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private PostService $postService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct
    (
        PostService $postService
    )
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     * @param PostIndexRequest $request
     * @return PostCollection
     */
    public function index(PostIndexRequest $request): PostCollection
    {
        $itemsPerPage = $request->validated('itemsPerPage');
        $page = $request->validated('page');
        $sortBy = $request->validated('sortBy');
        $orderBy = $request->validated('orderBy');

        $posts = $this->postService->filter($itemsPerPage, $page, $sortBy, $orderBy);

        return new PostCollection($posts);
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
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param string $postId
     * @return PostResource
     */
    public function show(string $postId): PostResource
    {
        $post = $this->postService->findById($postId);

        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
