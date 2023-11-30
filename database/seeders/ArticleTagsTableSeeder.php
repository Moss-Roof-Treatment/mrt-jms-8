<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArticleTag;

class ArticleTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 9; $i++) {

            ArticleTag::create([
                'title' => 'tag-' . $i,
                'slug' => 'tag-' . $i
            ]);
        }
    }
}
