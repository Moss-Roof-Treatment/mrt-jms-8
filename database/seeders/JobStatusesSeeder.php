<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobStatus;

class JobStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobStatus::create([
            'id' => 1,
            'title' => 'Quote Request',
            'calendar_title' => 'Pending Quote Request',
            'color' => '#db5800',
            'text_color' => '#ffffff',
            'description' => 'This is a pending quote request before a job has been created.'
        ]);

        JobStatus::create([
            'id' => 2,
            'title' => 'New',
            'calendar_title' => 'Inspection',
            'color' => '#fb76e9',
            'text_color' => '#000000',
            'description' => 'This job is new.'
        ]);

        JobStatus::create([
            'id' => 3,
            'title' => 'Pending',
            'calendar_title' => 'Quote Sent',
            'color' => '#ffffff',
            'text_color' => '#000000',
            'description' => 'This job has been accepted by the customer and no deposit has been paid.'
        ]);

        JobStatus::create([
            'id' => 4,
            'title' => 'Sold (Deposit Pending)',
            'calendar_title' => 'Start (Deposit Pending)',
            'color' => '#fb7198',
            'text_color' => '#000000',
            'description' => 'This job has been accepted by the customer and no deposit has been paid.'
        ]);

        JobStatus::create([
            'id' => 5,
            'title' => 'Sold (Deposit Paid)',
            'calendar_title' => 'Start (Deposit Paid)',
            'color' => '#ac00e6',
            'text_color' => '',
            'description' => 'This job has been accepted by the customer and a deposit has been paid.'
        ]);

        JobStatus::create([
            'id' => 6,
            'title' => 'Sold (Payment On Completion)',
            'calendar_title' => 'Start (Payment on Completion)',
            'color' => '#ac00e6',
            'text_color' => '',
            'description' => 'This job has been accepted by the customer and payment will be made on completion'
        ]);

        JobStatus::create([
            'id' => 7,
            'title' => 'Completed',
            'calendar_title' => 'Completed',
            'color' => '#95e572',
            'text_color' => '#000000',
            'description' => 'This job has been completed.'
        ]);

        JobStatus::create([
            'id' => 8,
            'title' => 'Invoiced',
            'calendar_title' => 'Invoiced',
            'color' => '#0099ff',
            'text_color' => '#000000',
            'description' => 'This job has been invoiced.'
        ]);

        JobStatus::create([
            'id' => 9,
            'title' => 'Paid',
            'calendar_title' => 'Paid',
            'color' => '#ffffff',
            'text_color' => '#000000',
            'description' => 'This job has been paid for in full.'
        ]);

        JobStatus::create([
            'id' => 10,
            'title' => 'Not Given',
            'calendar_title' => 'Not Given',
            'color' => '#ffffff',
            'text_color' => '#000000',
            'description' => 'This job has not been given.'
        ]);

        JobStatus::create([
            'id' => 11,
            'title' => 'Not Quoted',
            'calendar_title' => 'Not Quoted',
            'color' => '#ffffff',
            'text_color' => '#000000',
            'description' => 'A customer has been inputted into system but no need to quote for one reason or other.'
        ]);
    }
}
