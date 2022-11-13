<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Requests\Api\Post\UpdateRequest;

class PostController extends Controller
{
    private $model;

    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->model->where('user_id', auth()->id())->get();
        $posts = PostResource::collection($posts);
        return successMessageWithData('The data has been returned successfully', $posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $pathImage = uploadFile($request->cover_image, 'posts');

        $this->model->create(['cover_image' => $pathImage] + $request->validated());
        return successMessage('The post has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (auth()->id() != $post->user_id)
            return errorMessage('Unauthenticated', 403);

        $post = new PostResource($post);
        return successMessageWithData('The data has been returned successfully', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Post $post)
    {
        if (auth()->id() != $post->user_id)
            return errorMessage('Unauthenticated', 403);

        $pathImage = $post->cover_image;

        if ($request->cover_image) {
            deletFile($post->cover_image);
            $pathImage = uploadFile($request->cover_image, 'posts');
        }

        $post->update(['cover_image' => $pathImage] + $request->validated());
        return successMessage('The post has been modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (auth()->id() != $post->user_id)
            return errorMessage('Unauthenticated', 403);

        $post->delete();
        return successMessage('Post has been deleted successfully');
    }

    public function onlyTrashed()
    {
        $posts = $this->model->onlyTrashed()->get();
        $posts = PostResource::collection($posts);
        return successMessageWithData('The data has been returned successfully', $posts);
    }

    public function restore($id)
    {
        $post = $this->model->withTrashed()->find($id);

        if (! $post)
            return errorMessage('not found', 404);

        if (auth()->id() != $post->user_id)
            return errorMessage('Unauthenticated', 403);

        $post->restore();
        return successMessage('The data has been returned successfully');
    }

    public function forceDelete($id)
    {
        $post = $this->model->withTrashed()->find($id);

        if (auth()->id() != $post->user_id)
            abort(403);

        $post->forceDelete();
        return successMessage('Post has been deleted successfully');
    }
}
