<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::query()->delete();

        $users = User::all();
        $articles = Article::all();

        Comment::factory(20)->state(function () use ($users, $articles) {
            return [
                'author_id' => $users->random()->id,
                'article_id' => $articles->random()->id,
            ];
        })->create();
    }
}
