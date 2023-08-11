<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $user1 = \App\Models\User::first(); // Retrieve the first user

        Blog::create([
            'title' => 'First Blog',
            'content' => 'This is the content of the first blog.',
            'user_id' => $user1->id,
            'category'=>json_encode(['travel']),
           
            'view_count' => 0,
        ]);

        Blog::create([
            'title' => 'Second Blog',
            'content' => 'This is the content of the second blog.',
            'user_id' => $user1->id,
            'category'=>json_encode(['travel']),
            'view_count' => 0,
        ]);

        // Add more sample blogs if needed
    }
}
