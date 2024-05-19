<?php

namespace Database\Seeders;

use App\Constants\AppConstants;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::factory()->times(250)->create();

        // main user comments
        $user = User::where('email', AppConstants::MAIN_USER['email'])->first();
        if ($user) {
            $postIds = Post::whereNot('user_id', $user->id)->inRandomOrder()->pluck('id')->take(30)->toArray();
            foreach ($postIds as $postId) {
                Comment::factory()->create([
                    'post_id' => $postId,
                    'user_id' => $user->id,
                ]);
            }
        }

        for ($i = 0; $i < 5000; $i++) {
            $randomComment = Comment::inRandomOrder()->first();
            if ($randomComment) {
                $randomUserId = User::whereNot('id', $randomComment->user_id)->inRandomOrder()->first();
                Comment::factory()->create([
                    'post_id' => $randomComment->post_id,
                    'parent_id' => $randomComment->id,
                    'user_id' => $randomUserId,
                ]);
            }
        }
    }
}
