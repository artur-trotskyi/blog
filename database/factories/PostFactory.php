<?php

namespace Database\Factories;

use App\Models\User;
use App\Services\PostService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paragraphs = $this->faker->paragraphs(5);
        $slug = App::make(PostService::class)->createSlug($paragraphs[0], 100);

        return [
            'user_id' => User::factory(),
            'message' => implode("\n", $paragraphs),
            'slug' => $slug
        ];
    }
}
