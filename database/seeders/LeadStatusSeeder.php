<?php

namespace Database\Seeders;

use App\Models\LeadStatus;
use Illuminate\Database\Seeder;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LeadStatus::create([
            'colour_id' => 6,
            'title' => 'new',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 2,
            'title' => 'Online Quote',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 2,
            'title' => 'Spoke To & Explained Quote',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 2,
            'title' => 'Sent Text Message',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 2,
            'title' => 'Send Photo Of Quote With Text Message',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 2,
            'title' => 'Sent PDF Of Quote With Email',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 2,
            'title' => 'Sent Quote Through Post',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 2,
            'title' => 'Called Left A Message',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 3,
            'title' => 'Called & Spoke To Customer To Discuss Quote',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 3,
            'title' => 'Called & Left A Message',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 3,
            'title' => 'Sent A Text Message',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 3,
            'title' => 'Sent A Message',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 3,
            'title' => 'Sent An Email',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 3,
            'title' => 'Ask The Question',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 4,
            'title' => 'Waiting For The Response',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 4,
            'title' => 'Sounds Keen Ring Soon',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 4,
            'title' => 'Put On Automatic Email Pending List',
            'description' => ''
        ]);

        LeadStatus::create([
            'colour_id' => 4,
            'title' => 'Put On Email Discount List',
            'description' => ''
        ]);
    }
}
