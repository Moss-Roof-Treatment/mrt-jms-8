<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobType;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobType::create([
            'id' => 1,
            'title' => 'Minimum Charge',
            'description' => 'The minimum amount of work to be performed on the job.',
            'procedure' => 'The minimum amount of work to be performed on the job.',
            'is_selectable' => 1,
            'is_editable' => 1,
            'is_delible' => 0
        ]);

        JobType::create([
            'id' => 2,
            'title' => 'Standard Works',
            'description' => 'The standard amount of work to be performed on a job.',
            'procedure' => 'The standard amount of work to be performed on a job.',
            'is_selectable' => 1,
            'is_editable' => 1,
            'is_delible' => 0
        ]);

        JobType::create([
            'id' => 3,
            'title' => 'Difficulty Works',
            'description' => 'The most difficult amount of work to be performed on a job.',
            'procedure' => 'The most difficult amount of work to be performed on a job.',
            'is_selectable' => 1,
            'is_editable' => 1,
            'is_delible' => 0
        ]);
    }
}
