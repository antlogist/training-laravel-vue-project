<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->paragraph(),
            'user_id' => 1,
            'category_id' => 1,
            'subcategory_id' => 1
        ];
    }
}
