<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountRole;

class AccountRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountRole::create([
            'id' => 1,
            'title' => 'Super User',
            'description' => 'A super user staff account. This account is able to accesss and manage all areas of the application.',
            'route_title' => 'staff.show'
        ]);

        AccountRole::create([
            'id' => 2,
            'title' => 'Staff',
            'description' => 'A staff member account. This account is able to accesss all staff areas of the application.',
            'route_title' => 'staff.show'
        ]);

        AccountRole::create([
            'id' => 3,
            'title' => 'Tradesperson',
            'description' => 'A tradesperson account. This account is able to accesss all tradesperson areas of the application.',
            'route_title' => 'tradespersons.show'
        ]);

        AccountRole::create([
            'id' => 4,
            'title' => 'Contractor',
            'description' => 'A contractor account. This account is able to accesss all contractor areas of the application.',
            'route_title' => 'contractors.show'
        ]);

        AccountRole::create([
            'id' => 5,
            'title' => 'Customer',
            'description' => 'A standard user. This account is able to accesss all contractor areas of the application.',
            'route_title' => 'customers.show'
        ]);
    }
}
