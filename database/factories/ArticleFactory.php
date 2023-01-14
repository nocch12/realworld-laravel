<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->unique()->sentence(3);
        return [
            'title'       => $this->faker->sentence(3),
            'slug'        => $this->faker->unique()->slug(3),
            'description' => $this->faker->sentence(10),
            'body'        => $this->faker->text(),
        ];
    }
}
