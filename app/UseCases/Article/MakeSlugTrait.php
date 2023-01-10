<?php declare(strict_types=1);

namespace App\UseCases\Article;

trait MakeSlugTrait {
    private function makeSlug(string $title)
    {
        return strtotime('now') . '-' . strtolower(preg_replace('/　|\s+/', '-', $title));
    }
}
