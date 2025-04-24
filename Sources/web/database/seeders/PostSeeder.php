<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\V1\News\Models\Post;
use App\Domains\V1\Auth\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Seed the posts table.
     *
     * @return void
     */
    public function run()
    {
        // Create 30 posts with random users
        Post::factory()->count(30)->create([
            'user_id' => User::inRandomOrder()->first()->id, // Assign random user to each post
        ]);
    }
}