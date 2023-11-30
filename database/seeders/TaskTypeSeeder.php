<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskType;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskType::create([
            'id' => 1,
            'title' => 'Areas To Be Treated',
            'description' => 'All roof areas that require treatment.'
        ]);

        TaskType::create([
            'id' => 2,
            'title' => 'Additions',
            'description' => 'All additional items that require treatment.'
        ]);

        TaskType::create([
            'id' => 3,
            'title' => 'Other Works',
            'description' => 'All other works that are required to be performed.'
        ]);
    }
}
