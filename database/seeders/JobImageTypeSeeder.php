<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobImageType;

class JobImageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobImageType::create([
            'id' => 1,
            'title' => 'SWMS',
            'description' => 'Images of the SWMS.'
        ]);

        JobImageType::create([
            'id' => 2,
            'title' => 'Inspection',
            'description' => 'Images of the inspection.'
        ]);

        JobImageType::create([
            'id' => 3,
            'title' => 'Roof Outline',
            'description' => 'Images of the roof outilne.'
        ]);

        JobImageType::create([
            'id' => 4,
            'title' => 'Before',
            'description' => 'Images before work is started.'
        ]);

        JobImageType::create([
            'id' => 5,
            'title' => 'Part Complete',
            'description' => 'Images during the work being performed.'
        ]);

        JobImageType::create([
            'id' => 6,
            'title' => 'Complete',
            'description' => 'Images of the of the completed job.'
        ]);

        JobImageType::create([
            'id' => 7,
            'title' => 'Overall',
            'description' => 'Images of the overall job.'
        ]);

        JobImageType::create([
            'id' => 8,
            'title' => 'Carpenter',
            'description' => 'Images that are uploaded by the Carpenter.'
        ]);

        JobImageType::create([
            'id' => 9,
            'title' => 'Plumber',
            'description' => 'Images that are uploaded by the Plumber.'
        ]);
    }
}
