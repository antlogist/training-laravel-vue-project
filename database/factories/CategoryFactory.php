<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use \App\Models\User;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->catchPhrase();

        return [
            'user_id' => User::all()->random()->id,
            'title' => $title,
            'slug' => Str::slug($title, '-')
        ];
    }
}
