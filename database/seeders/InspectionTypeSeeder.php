<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InspectionType;

class InspectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InspectionType::create([
            'id' => 1,
            'title' => 'Online Inspection',
            'description' => 'An online inspection.'
        ]);

        InspectionType::create([
            'id' => 2,
            'title' => 'Drive By Inspection',
            'description' => 'A drive by inspection.'
        ]);

        InspectionType::create([
            'id' => 3,
            'title' => 'Standard Inspection',
            'description' => 'A standard inspection.'
        ]);

        InspectionType::create([
            'id' => 4,
            'title' => 'Extended Inspection',
            'description' => 'An extended inspection.'
        ]);

        InspectionType::create([
            'id' => 5,
            'title' => 'None',
            'description' => 'No inspection is required.'
        ]);
    }
}
