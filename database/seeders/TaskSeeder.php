<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::create([
            'task_type_id' => 1,
            'dimension_id' => 1,
            'title' => 'task1',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 1000
        ]);

        Task::create([
            'task_type_id' => 2,
            'dimension_id' => 2,
            'title' => 'task2',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 2000
        ]); 

        Task::create([
            'task_type_id' => 3,
            'dimension_id' => 3,
            'title' => 'task3',
            'procedure' => 'This is a procedure.',
            'description' => 'This is a description.',
            'price' => 3000
        ]); 
    }
}
