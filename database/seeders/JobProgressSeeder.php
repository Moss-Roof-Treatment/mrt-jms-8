<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobProgress;

class JobProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobProgress::create([
            'title' => 'Pending',
            'description' => 'This job is pending.'
        ]);

        JobProgress::create([
            'title' => 'Customer Contacted',
            'description' => 'The customer has been contacted.'
        ]);

        JobProgress::create([
            'title' => 'All Work Completed',
            'description' => 'This job has has all work completed.'
        ]);

        JobProgress::create([
            'title' => 'Start Date Set',
            'description' => 'Start date for the job has been set with customer.'
        ]);

        JobProgress::create([
            'title' => 'Treatment Applied',
            'description' => 'Moss roof treatment has been applied.'
        ]);
    }
}
