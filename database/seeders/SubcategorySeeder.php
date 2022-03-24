<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Subcategory;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = ['Variables', 'Operators', 'Primitives'];

        foreach ($subcategories as $subcategory) {
            Subcategory::create([
                'user_id' => 1,
                'title' => $subcategory,
                'slug' => Str::slug($subcategory),
                'category_id' => 1
              ]);
        }
    }
}
