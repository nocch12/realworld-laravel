<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\UseCases\Comment\StoreAction;
use Request;

class CommentController extends Controller
{
    public function list(Article $article)
    {
        return new CommentCollection($article->comments);
    }

    public function store(StoreRequest $request, Article $article, StoreAction $action)
    {
        $comment = $action($article, $request->makeComment());
        return new CommentResource($comment);
    }

    public function destroy(Request $request, Article $article, Comment $comment)
    {
        $this->authorize('delete', $comment);
        return $comment->deleteOrFail();
    }
}
