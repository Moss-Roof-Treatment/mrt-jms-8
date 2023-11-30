<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FollowUpCallStatus;

class FollowUpCallStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FollowUpCallStatus::create([
            'colour_id' => 2,
            'title' => 'Online Quote',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 2,
            'title' => 'Spoke To & Explained Quote',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 2,
            'title' => 'Sent Text Message',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 2,
            'title' => 'Send Photo Of Quote With Text Message',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 2,
            'title' => 'Sent PDF Of Quote With Email',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 2,
            'title' => 'Sent Quote Through Post',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 2,
            'title' => 'Called Left A Message',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 3,
            'title' => 'Called & Spoke To Customer To Discuss Quote',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 3,
            'title' => 'Called & Left A Message',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 3,
            'title' => 'Sent A Text Message',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 3,
            'title' => 'Sent A Message',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 3,
            'title' => 'Sent An Email',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 3,
            'title' => 'Ask The Question',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 4,
            'title' => 'Waiting For The Response',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 4,
            'title' => 'Sounds Keen Ring Soon',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 4,
            'title' => 'Put On Automatic Email Pending List',
            'description' => ''
        ]);

        FollowUpCallStatus::create([
            'colour_id' => 4,
            'title' => 'Put On Email Discount List',
            'description' => ''
        ]);
    }
}
