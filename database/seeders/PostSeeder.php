<?php

namespace Database\Seeders;

use App\Constants\AppConstants;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()->times(30)->create();

        $user = User::where('email', AppConstants::MAIN_USER['email'])->first();
        if ($user) {
            Post::factory()->times(5)->create(['user_id' => $user->id]);
        }
    }
}
