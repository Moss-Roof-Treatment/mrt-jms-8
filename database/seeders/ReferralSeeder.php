<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Referral;

class ReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Referral::create([
            'id' => 7,
            'title' => 'Not Registered',
            'description' => ''
        ]);

        Referral::create([
            'id' => 16,
            'title' => 'LATR Website',
            'description' => ''
        ]);

        Referral::create([
            'id' => 28,
            'title' => 'LATR Google',
            'description' => ''
        ]);

        Referral::create([
            'id' => 26,
            'title' => 'LATR Advertiser',
            'description' => ''
        ]);

        Referral::create([
            'id' => 2,
            'title' => 'LATR House Sign',
            'description' => ''
        ]);

        Referral::create([
            'id' => 39,
            'title' => 'MRT Website',
            'description' => ''
        ]);

        Referral::create([
            'id' => 43,
            'title' => 'MRT Ballarat Home',
            'description' => ''
        ]);

        Referral::create([
            'id' => 42,
            'title' => 'MRT Advertiser Ad',
            'description' => ''
        ]);

        Referral::create([
            'id' => 38,
            'title' => 'MRT Domain Geelong',
            'description' => ''
        ]);

        Referral::create([
            'id' => 34,
            'title' => 'MRT BALLARAT COURIER',
            'description' => ''
        ]);

        Referral::create([
            'id' => 44,
            'title' => 'MRT Facebook',
            'description' => ''
        ]);

        Referral::create([
            'id' => 40,
            'title' => 'MRT Google Ad',
            'description' => ''
        ]);

        Referral::create([
            'id' => 32,
            'title' => 'MRT House Sign',
            'description' => ''
        ]);

        Referral::create([
            'id' => 41,
            'title' => 'MRT Cold Call',
            'description' => ''
        ]);

        Referral::create([
            'id' => 47,
            'title' => 'MRT Waurn Ponds',
            'description' => ''
        ]);

        Referral::create([
            'id' => 46,
            'title' => 'MRT Sanctuary Lakes',
            'description' => ''
        ]);

        Referral::create([
            'id' => 45,
            'title' => 'MRT Shopping Centers',
            'description' => ''
        ]);

        Referral::create([
            'id' => 25,
            'title' => 'Yellow Pages Online',
            'description' => ''
        ]);

        Referral::create([
            'id' => 1,
            'title' => 'Yellow Pages Book',
            'description' => ''
        ]);

        Referral::create([
            'id' => 4,
            'title' => 'Referral',
            'description' => ''
        ]);

        Referral::create([
            'id' => 15,
            'title' => 'Tradesman Truck',
            'description' => ''
        ]);

        Referral::create([
            'id' => 10,
            'title' => 'Independent',
            'description' => ''
        ]);

        Referral::create([
            'id' => 30,
            'title' => 'Whyndam Star Weekly',
            'description' => ''
        ]);

        Referral::create([
            'id' => 37,
            'title' => 'Melton Star Weekly',
            'description' => ''
        ]);

        Referral::create([
            'id' => 8,
            'title' => 'Geelong News',
            'description' => ''
        ]);

        Referral::create([
            'id' => 9,
            'title' => 'Echo',
            'description' => ''
        ]);

        Referral::create([
            'id' => 3,
            'title' => 'Info Pages',
            'description' => ''
        ]);

        Referral::create([
            'id' => 27,
            'title' => 'Bellarine Times',
            'description' => ''
        ]);

        Referral::create([
            'id' => 14,
            'title' => 'Surf Coast Times',
            'description' => ''
        ]);

        Referral::create([
            'id' => 29,
            'title' => 'Leopold Local',
            'description' => ''
        ]);

        Referral::create([
            'id' => 35,
            'title' => 'Repeat Customer',
            'description' => ''
        ]);

        Referral::create([
            'id' => 5,
            'title' => 'Radio',
            'description' => ''
        ]);

        Referral::create([
            'id' => 36,
            'title' => 'Business Contact',
            'description' => ''
        ]);

        Referral::create([
            'id' => 11,
            'title' => 'YP North Western',
            'description' => ''
        ]);

        Referral::create([
            'id' => 12,
            'title' => 'YP South Western',
            'description' => ''
        ]);

        Referral::create([
            'id' => 6,
            'title' => 'Highway Sign',
            'description' => ''
        ]);

        Referral::create([
            'id' => 18,
            'title' => 'Royal Geelong Show',
            'description' => ''
        ]);

        Referral::create([
            'id' => 19,
            'title' => 'Westfield Shopping Centre',
            'description' => ''
        ]);

        Referral::create([
            'id' => 20,
            'title' => 'Govt Web Site',
            'description' => ''
        ]);

        Referral::create([
            'id' => 17,
            'title' => 'Home & Garden Show',
            'description' => ''
        ]);

        Referral::create([
            'id' => 21,
            'title' => 'Fletchers Insulation Website',
            'description' => ''
        ]);

        Referral::create([
            'id' => 22,
            'title' => 'Leaflet Drop',
            'description' => ''
        ]);

        Referral::create([
            'id' => 23,
            'title' => 'Real Estate Mail Out',
            'description' => ''
        ]);

        Referral::create([
            'id' => 24,
            'title' => 'Corio Shopping Center',
            'description' => ''
        ]);

        Referral::create([
            'id' => 31,
            'title' => 'True Local',
            'description' => ''
        ]);

        Referral::create([
            'id' => 33,
            'title' => 'Easy Finder',
            'description' => ''
        ]);

        Referral::create([
            'id' => 49,
            'title' => 'Instagram',
            'description' => 'Went to our Instagram page.',
            'is_editable' => 1,
            'is_delible' => 0
        ]);
    }
}
