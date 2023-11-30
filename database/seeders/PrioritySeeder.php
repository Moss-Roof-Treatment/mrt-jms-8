<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Priority;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::create([
            'id' => 1,
            'colour_id' => 2,
            'title' => 'Critical',
            'resolution_amount' => '4',
            'resolution_period' => 'Hours'
        ]);

        Priority::create([
            'id' => 2,
            'colour_id' => 3,
            'title' => 'Important',
            'resolution_amount' => '24',
            'resolution_period' => 'Hours'
        ]);

        Priority::create([
            'id' => 3,
            'colour_id' => 6,
            'title' => 'Normal',
            'resolution_amount' => '3',
            'resolution_period' => 'Days'
        ]);

        Priority::create([
            'id' => 4,
            'colour_id' => 7,
            'title' => 'Low',
            'resolution_amount' => '5',
            'resolution_period' => 'Days'
        ]);
    }
}
