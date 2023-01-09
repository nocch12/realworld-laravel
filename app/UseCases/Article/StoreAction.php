<?php declare(strict_types=1);

namespace App\UseCases\Article;

use App\Models\Article;
use App\Models\Tag;
use Auth;
use DB;
use Illuminate\Support\Collection;

final class StoreAction
{
    public function __invoke(Article $article, Collection $tags)
    {
        $article->author_id = Auth::user()->id;
        $article->slug = $this->makeSlug($article->title);

        DB::beginTransaction();
        try {
            $tags = $tags->map(function (string $tag) {
                return Tag::firstOrCreate(['name' => $tag]);
            });
            $article->save();
            $article->tags()->attach($tags->pluck('id'));
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $article->refresh();
    }

    private function makeSlug(string $title)
    {
        return strtolower(preg_replace('/　|\s+/', '-', $title));
    }
}
