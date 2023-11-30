<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountClass;

class AccountClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountClass::create([
            'id' => 1,
            'title' => 'Staff',
            'description' => 'A Standard Staff Memeber Account'
        ]);

        AccountClass::create([
            'id' => 2,
            'title' => 'Tradesperson',
            'description' => 'A Tradesperson Staff Account'
        ]);

        AccountClass::create([
            'id' => 3,
            'title' => 'Carpenter',
            'description' => 'A Carpenter Account'
        ]);
        
        AccountClass::create([
            'id' => 4,
            'title' => 'Plumber',
            'description' => 'A Plumber Account'
        ]);

        AccountClass::create([
            'id' => 5,
            'title' => 'Individual',
            'description' => 'A Standard Customer Account'
        ]);

        AccountClass::create([
            'id' => 6,
            'title' => 'Real Estate Agent',
            'description' => 'A Standard Customer Account'
        ]);

        AccountClass::create([
            'id' => 7,
            'title' => 'Landlord',
            'description' => 'A Standard Customer Account'
        ]);

        AccountClass::create([
            'id' => 8,
            'title' => 'Maintenance Manager',
            'description' => 'A Standard Customer Account'
        ]);

        AccountClass::create([
            'id' => 9,
            'title' => 'Shopping Centre Manager',
            'description' => 'A Standard Customer Account'
        ]);
    }
}
