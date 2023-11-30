<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoginStatus;

class LoginStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoginStatus::create([
            'id' => 1,
            'title' => 'Is Active',
            'description' => 'This user can access the application.',
            'message' => 'This user can access the application.',
            'can_login' => 1,
            'colour_id' => 4
        ]);

        LoginStatus::create([
            'id' => 2,
            'title' => 'Is Outstanding Payment',
            'description' => 'This user can access the application but is displayed a warning message that payment is required upon login.',
            'message' => 'Please contact the builing department to discuss your account.',
            'can_login' => 1,
            'colour_id' => 3
        ]);

        LoginStatus::create([
            'id' => 3,
            'title' => 'Is Requiring Contact',
            'description' => 'This user can access the application but is displayed a warning message that contact is required upon login.',
            'message' => 'Please contact us to discuss your account.',
            'can_login' => 1,
            'colour_id' => 3
        ]);

        LoginStatus::create([
            'id' => 4,
            'title' => 'Is Suspended',
            'description' => 'This user account has been suspended from logging in and cannot access to the application.',
            'message' => 'This user account has been suspended from logging in.',
            'can_login' => 0,
            'colour_id' => 2
        ]);

        LoginStatus::create([
            'id' => 5,
            'title' => 'Is Inactive',
            'description' => 'This user account is inactive and cannot access to the application.',
            'message' => 'This user account is inactive.',
            'can_login' => 0,
            'colour_id' => 2
        ]);

        LoginStatus::create([
            'id' => 6,
            'title' => 'Is Deleted',
            'description' => 'This user account has been deleted and cannot access to the application.',
            'message' => 'This user account has been deleted.',
            'can_login' => 0,
            'colour_id' => 2
        ]);
    }
}
