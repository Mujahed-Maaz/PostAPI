<?php

namespace App\Http\Controllers\api\V1;

use App\Filters\V1\PostFilter;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\V1\StorePostRequest;
use App\Http\Requests\V1\UpdatePostRequest;
use App\Http\Resources\V1\PostCollection;
use App\Http\Resources\V1\PostResource;
use App\Models\User;

use function Symfony\Component\Clock\now;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new PostFilter();
        $filterItems = $filter->transform($request);

        $includeComments = $request->query('includeComments');
        $posts = Post::where($filterItems);

        if ($includeComments) {
            $posts = $posts->with('comments');
        }

        return new PostCollection($posts->paginate()->appends($request->query()));
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
    public function store(StorePostRequest $request)
    {
        return new PostResource(Post::create(array_merge($request->all(), ['user_id' => auth()->id(), 'published_at' => now()])));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $includeComments = request()->query('includeComments');

        if ($includeComments) {
            return new PostResource($post->loadMissing('comments'));
        }

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
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());
        return "The post updated successfully";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Post $post)
    {
        $post->delete();
        return "You've successfully soft deleted this post";
    }

    public function restore($id)
    {
        Post::withTrashed()->find($id)->restore();
        return "You've successfully resotred this post";
    }

    public function forceDelete($id)
    {
        Post::withTrashed()->find($id)->forceDelete();
        return "You've successfully deleted this post forever";
    }

    public function getSoftDeletedPosts()
    {
        $softDeletedPosts = Post::onlyTrashed()->get();
        if (auth()->user()->tokenCan('delete'))
            return new PostCollection($softDeletedPosts);
        else
            return abort(403);
    }
}
