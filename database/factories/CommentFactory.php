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
        $paragraphs = $this->faker->paragraphs(rand(1, 3));
        $user = User::whereNotIn('id', Post::pluck('user_id')->toArray())->inRandomOrder()->first();

        return [
            'post_id' => Post::factory(),
            'parent_id' => null,
            'user_id' => $user->id,
            'message' => implode("\n", $paragraphs),
        ];
    }
}
