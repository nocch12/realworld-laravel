<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\UseCases\Comment\StoreAction;

class CommentController extends Controller
{
    public function list()
    {
    }

    public function store(StoreRequest $request, Article $article, StoreAction $action)
    {
        $comment = $action($article, $request->makeComment());
        logger('e', [$comment->author]);
        return new CommentResource($comment);
    }
}
