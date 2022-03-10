<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->text(),
            'image' => 'posts-images/' . $this->faker->image('public/storage/posts-images', 640, 480, null, false), // con false me regresa solo: imagen.jpg
        ];
    }
}
