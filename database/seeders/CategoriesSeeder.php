<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     *
     * @return void
     */
    public function run(): void
    {
        $categories = [
            1 => [
                'name' => 'Malé autá'
            ],
            2 => [
                'name' => 'Veľké autá'
            ]
        ];

        foreach ($categories as $category_id => $catData)
        {
            $category = Category::find($category_id);

            $newSlug = Str::slug($catData['name']);
            $slug_count = Category::where("slug", "like", $newSlug . "%")->get()->count();
            $slug_id = ($slug_count ?? 0) + 1;

            if(!$category)
            {
                $newCategory = new Category();
                $newCategory['id'] = $category_id;
                $newCategory['name'] = $catData['name'];
                $newCategory['slug'] = $newSlug . "-" . $slug_id;
                $newCategory->save();
            }
        }
    }
}
