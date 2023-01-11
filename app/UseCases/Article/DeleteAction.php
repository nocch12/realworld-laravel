<?php declare(strict_types=1);

namespace App\UseCases\Article;

use App\Models\Article;

final class DeleteAction
{
    public function __invoke(Article $article)
    {
        return $article->deleteOrFail();
    }
}
