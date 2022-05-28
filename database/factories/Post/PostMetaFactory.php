<?php
namespace Database\Factories\Post;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostMetaFactory extends Factory
{
    /**
     * Определить состояние модели по умолчанию.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_id' => rand(1, 20),
            'meta_key' => 'post_content',
            'meta_value' => $this->faker->paragraph,
            'created_at' => $this->faker->dateTimeBetween('-60 days', '-30 days'),
            'updated_at' => $this->faker->dateTimeBetween('-20 days', '-1 days'),
        ];
    }
}
