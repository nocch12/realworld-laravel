<?php declare(strict_types=1);

namespace App\UseCases\Article;

use App\Models\Article;
use Auth;
use Illuminate\Database\Eloquent\Builder;

final class FeedAction
{
    public function __invoke(
        int $limit = 20,
        int $offset = 0,
    )
    {
        $userIds = Auth::user()->following->pluck('id')->toArray();

        $builder = Article::whereHas('author', function (Builder $query) use ($userIds) {
            $query->whereIn('author_id', $userIds);
        })
        ->orderBy('created_at')
        ->skip(($offset))
        ->take($limit);

        return $builder->get();
    }
}
