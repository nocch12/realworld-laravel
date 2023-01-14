<?php declare(strict_types=1);

namespace App\UseCases\Article;

use App\Models\Article;
use DB;

final class UpdateAction
{
    use MakeSlugTrait;

    public function __invoke(Article $article)
    {
        if ($article->isDirty('title')) {
            $article->slug = $this->makeSlug($article->title);
        }

        DB::beginTransaction();
        try {
            $article->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $article->refresh();
    }
}
