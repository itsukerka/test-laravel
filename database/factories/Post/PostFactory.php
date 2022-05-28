<?php

namespace Database\Factories\Post;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Определить состояние модели по умолчанию.
     *
     * @return array
     */
    public function definition()
    {
        $content = explode('. ', $this->faker->paragraph);
        return [
            'author_id' => '1',
            'title' => $content[0],
            'excerpt' => $content[1].'.',
            'slug' => str_replace(' ', '-', $content[0]),
            'status' => 'publish',
            'created_at' => $this->faker->dateTimeBetween('-60 days', '-30 days'),
            'updated_at' => $this->faker->dateTimeBetween('-20 days', '-1 days'),
        ];
    }
}
