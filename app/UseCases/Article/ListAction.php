<?php declare(strict_types=1);

namespace App\UseCases\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

final class ListAction
{
    public function __invoke(
        string $tag = null,
        string $author = null,
        string $favorited = null,
        int $limit = 20,
        int $offset = 0,
    )
    {
        $builder = Article::query();

        if ($author) {
            $builder->whereHas('author', function (Builder $query) use ($author) {
                $query->where('username', $author);
            });
        } elseif ($favorited) {
            $builder->whereHas('favoritedUsers', function (Builder $query) use ($author) {
                $query->where('username', $author);
            });
        }

        if ($tag) {
            $builder->whereHas('tags', function (Builder $query) use ($tag) {
                $query->where('name', $tag);
            });
        }

        $builder->skip(($offset))->take($limit);

        return $builder->get();
    }
}
