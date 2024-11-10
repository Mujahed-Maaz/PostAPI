<?php

namespace App\Http\Controllers\api\V1;

use App\Filters\V1\CommentFilter;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCommentRequest;
use App\Http\Requests\V1\UpdateCommentRequest;
use App\Http\Resources\V1\CommentCollection;
use App\Http\Resources\V1\CommentResource;
use Illuminate\Http\Request;

use function Symfony\Component\Clock\now;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CommentFilter();
        $filterItems = $filter->transform($request);

        if (count($filterItems) == 0) {
            return new CommentCollection(Comment::paginate());
        } else {
            $comments = Comment::where($filterItems)->paginate();
            return new CommentCollection($comments->appends($request->query()));
        }
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
    public function store(StoreCommentRequest $request)
    {
        return new CommentResource(Comment::create(array_merge($request->all(), ['user_id' => auth()->id(), 'published_at' => now()])));
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
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
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->all());
        return "The comment updated successfully";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return "You've successfully soft deleted this comment";
    }

    public function restore($id)
    {
        Comment::withTrashed()->find($id)->restore();
        return "You've successfully resotred this comment";
    }

    public function forceDelete($id)
    {
        Comment::withTrashed()->find($id)->forceDelete();
        return "You've successfully deleted this comment forever";
    }

    public function getSoftDeletedComments()
    {
        $softDeletedComments = Comment::onlyTrashed()->get();
        if (auth()->user()->tokenCan('delete'))
            return new CommentCollection($softDeletedComments);
        else
            return abort(403);
    }
}
