<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::all()->random()->national_id;
        $post = Post::all()->random()->id;

        return [
            'user_id' => $user,
            'post_id' => $post,
            'content' => fake()->text(),
            'image_path' => null
        ];
    }
}
