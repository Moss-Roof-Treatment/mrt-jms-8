<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReminderResponseStatus;

class ReminderResponseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1.
        ReminderResponseStatus::create([
            'title' => 'Pending',
            'description' => 'Pending'
        ]);

        // 2.
        ReminderResponseStatus::create([
            'title' => 'Waiting',
            'description' => 'Please keep us in mind – we will contact you soon.'
        ]);

        // 3.
        ReminderResponseStatus::create([
            'title' => 'Has Response',
            'description' => 'No quote has been sent.'
        ]);

        // 4.
        ReminderResponseStatus::create([
            'title' => 'Contact',
            'description' => "I've got further questions - Can you contact me?"
        ]);

        // 5.
        ReminderResponseStatus::create([
            'title' => 'Contacted',
            'description' => 'The customer has been contacted.'
        ]);

        // 6.
        ReminderResponseStatus::create([
            'title' => 'Proceed',
            'description' => "Yes, we would like to proceed. What's the next step?"
        ]);

        // 7.
        ReminderResponseStatus::create([
            'title' => 'Do Not Proceed',
            'description' => 'Do not want to proceed.'
        ]);
    }
}
