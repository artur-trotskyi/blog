<?php

namespace Database\Seeders;

use App\Constants\AppConstants;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->times(100)->create();
        User::create([
            'username' => AppConstants::MAIN_USER['username'],
            'email' => AppConstants::MAIN_USER['email'],
            'email_verified_at' => now(),
            'password' => Hash::make(AppConstants::MAIN_USER['password']),
            'remember_token' => Str::random(10),
        ]);
    }
}
