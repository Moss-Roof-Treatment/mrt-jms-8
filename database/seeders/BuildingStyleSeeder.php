<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BuildingStyle;

class BuildingStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuildingStyle::create([
            'id' => 1,
            'title' => 'Single Storey',
            'description' => 'A single story building.'
        ]);

        BuildingStyle::create([
            'id' => 2,
            'title' => 'Double Storey',
            'description' => 'A double story building.'
        ]);

        BuildingStyle::create([
            'id' => 3,
            'title' => 'Single and Double Storey',
            'description' => 'A single and double story building.'
        ]);
    }
}
