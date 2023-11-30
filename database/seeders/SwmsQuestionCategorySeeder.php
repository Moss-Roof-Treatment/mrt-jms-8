<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SwmsQuestionCategory;

class SwmsQuestionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SwmsQuestionCategory::create([
            'id' => 1,
            'title' => 'Tool box check list',
            'description' => 'SWMS question group one.'
        ]);

        SwmsQuestionCategory::create([
            'id' => 2,
            'title' => 'What are the hazards and risks',
            'description' => 'SWMS question group two.'
        ]);

        SwmsQuestionCategory::create([
            'id' => 3,
            'title' => 'Activities to be carried out',
            'description' => 'SWMS question group three.'
        ]);

        SwmsQuestionCategory::create([
            'id' => 4,
            'title' => 'Risk control measures',
            'description' => 'SWMS question group four.'
        ]);
    }
}
