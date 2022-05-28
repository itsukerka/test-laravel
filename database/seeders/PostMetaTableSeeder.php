<?php

namespace Database\Seeders;

use App\Models\Post\PostMeta;
use Illuminate\Database\Seeder;

class PostMetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // создать 20 постов блога
        PostMeta::factory()
            ->count(50)
            ->create();
    }
}
