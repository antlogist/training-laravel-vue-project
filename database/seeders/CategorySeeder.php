<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = ['JavaScript', 'PHP', 'Laravel'];

        foreach ($categories as $category) {
            Category::create([
                'user_id' => 1,
                'title' => $category,
                'slug' => Str::slug($category)
              ]);
        }

    }
}
