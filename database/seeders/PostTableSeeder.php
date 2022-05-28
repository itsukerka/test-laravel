<?php

namespace Database\Seeders;

use App\Models\Post\Post;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // создать 20 постов блога
        Post::factory()
            ->count(50)
            ->create();
    }
}
