<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->delete();

        User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $tags = Tag::all();

        User::factory(10)->create()->each(function (User $user) use ($tags) {
            Article::factory(rand(0, 3))->create([
                'author_id' => $user->id,
            ])->each(function (Article $article) use ($tags) {
                $attachTags = $tags->random(rand(1, 3))->pluck('id')->toArray();
                if ($attachTags) {
                    $article->tags()->attach($attachTags);
                }
            });
        });
    }
}
