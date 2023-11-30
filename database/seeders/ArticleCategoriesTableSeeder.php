<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArticleCategory;

class ArticleCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 9; $i++) {

            ArticleCategory::create([
                'title' => 'category-' . $i,
                'slug' => 'category-' . $i
            ]);
        }
    }
}