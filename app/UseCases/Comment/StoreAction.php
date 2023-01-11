<?php declare(strict_types=1);

namespace App\UseCases\Comment;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

final class StoreAction
{
    public function __invoke(Article $article, Comment $comment)
    {
        $comment->author()->associate(Auth::user());
        $comment->article()->associate($article);
        $comment->save();
        return $comment->refresh();
    }
}
