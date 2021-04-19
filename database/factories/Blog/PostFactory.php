<?php

namespace Database\Factories\Blog;

use App\Models\Blog\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realTextBetween(10, 100),
            'content' => $this->faker->realTextBetween(120, 400),
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}
