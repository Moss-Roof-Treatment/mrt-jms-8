<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // Super User - 1
        User::create([
            'username' => 'lmcconsultingau@gmail.com',
            'email' => 'lmcconsultingau@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'first_name' => 'David',
            'last_name' => 'Kavanagh',
            'street_address' => '4 Titan Street',
            'suburb' => 'Whittington',
            'state_id' => 7,
            'postcode' => 3219,
            'home_phone' => null,
            'mobile_phone' => '0401765815',
            'account_class_id' => 1, // Staff.
            'account_role_id' => 1, // Super User.
            'referral_id' => 1,
            'user_description' => 'Application and Website Administrator',
            'business_name' => 'LMC Consulting',
            'abn' => '93798056642',
            'business_phone' => '0401765815',
            'business_position' => 'CEO',
            'business_contact_phone' => '0401765815',
            'bank_name' => 'Commonwealth Bank',
            'bank_bsb' => '063-512',
            'bank_account_name' => 'David Kavanagh',
            'bank_account_number' => '11076616',
            'business_description' => 'Full service digital consulting agency.',
            'kin_name' => 'Julie Kavanagh',
            'kin_address' => '4 Titan Street, Whittington, 3219',
            'Kin_mobile_phone' => '0411295118',
            'kin_relationship' => 'Mother',
        ]);

        // Stuart - 2
        User::create([
            'username' => 'stuart@mossrooftreatment.com.au',
            'email' => 'stuart@mossrooftreatment.com.au',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'first_name' => 'Stuart',
            'last_name' => 'McKee',
            'street_address' => '27-29 Point Henry Road',
            'suburb' => 'Moolap',
            'state_id' => 7,
            'postcode' => 3224,
            'home_phone' => '04188996437',
            'mobile_phone' => '04188996437',
            'account_class_id' => 1, // Staff.
            'account_role_id' => 2, // Staff.
            'referral_id' => 1,
            'user_description' => '',
            'business_name' => 'MOSS ROOF TREATMENT PTY LTD',
            'abn' => 33635776242,
            'business_phone' => '04188996437',
            'business_position' => 'Staff',
            'business_contact_phone' => '04188996437',
            'bank_name' => 'Australia and New Zealand Banking Group Limited',
            'bank_bsb' => '013-645',
            'bank_account_name' => 'MOSS ROOF TREATMENT PTY LTD',
            'bank_account_number' => '00000000',
        ]);

        // Debbie - 3
        User::create([
            'username' => 'debbie@mossrooftreatment.com.au',
            'email' => 'debbie@mossrooftreatment.com.au',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'first_name' => 'Debbie',
            'last_name' => 'McKee',
            'street_address' => '27-29 Point Henry Road',
            'suburb' => 'Moolap',
            'state_id' => 7,
            'postcode' => 3224,
            'home_phone' => '04188996437',
            'mobile_phone' => '04188996437',
            'account_class_id' => 1, // Staff.
            'account_role_id' => 2, // Staff.
            'referral_id' => 1,
            'user_description' => '',
            'business_name' => 'MOSS ROOF TREATMENT PTY LTD',
            'abn' => 33635776242,
            'business_phone' => '04188996437',
            'business_position' => 'Staff',
            'business_contact_phone' => '04188996437',
            'bank_name' => 'Australia and New Zealand Banking Group Limited',
            'bank_bsb' => '013-645',
            'bank_account_name' => 'MOSS ROOF TREATMENT PTY LTD',
            'bank_account_number' => '00000000',
        ]);

        // Connor - 4 - STAFF
        User::create([
            'username' => 'connor@mossrooftreatment.com.au',
            'email' => 'connor@mossrooftreatment.com.au',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'first_name' => 'Connor',
            'last_name' => 'McKee',
            'street_address' => '27-29 Point Henry Road',
            'suburb' => 'Moolap',
            'state_id' => 7,
            'postcode' => 3224,
            'home_phone' => '04188996437',
            'mobile_phone' => '04188996437',
            'account_class_id' => 1, // Staff.
            'account_role_id' => 2, // Staff.
            'referral_id' => 1,
            'user_description' => '',
            'business_name' => 'MOSS ROOF TREATMENT PTY LTD',
            'abn' => 33635776242,
            'business_phone' => '04188996437',
            'business_position' => 'Staff',
            'business_contact_phone' => '04188996437',
            'bank_name' => 'Australia and New Zealand Banking Group Limited',
            'bank_bsb' => '013-645',
            'bank_account_name' => 'MOSS ROOF TREATMENT PTY LTD',
            'bank_account_number' => '00000000',
        ]);

        // Connor - 5 - TRADESPERSON
        User::create([
            'username' => 'connor12@iinet.net.au',
            'email' => 'connor12@iinet.net.au',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'first_name' => 'Connor',
            'last_name' => 'McKee',
            'street_address' => '54-56 Christies Road',
            'suburb' => 'Leopold',
            'state_id' => 7,
            'postcode' => 3224,
            'home_phone' => '',
            'mobile_phone' => '0467508595',
            'account_class_id' => 2, // Tradesperson.
            'account_role_id' => 3, // Tradesperson.
            'referral_id' => 1,
            'user_description' => 'Friendly, Organised tradesmen, high quality work and communication.',
            'business_name' => 'MOSS ROOF TREATMENT PTY LTD',
            'abn' => 33635776242,
            'business_phone' => '04188996437',
            'business_position' => 'Tradesperson',
            'business_contact_phone' => '0467508595',
            'bank_name' => 'ING',
            'bank_bsb' => '923-100',
            'bank_account_name' => 'CONNOR MCKEE',
            'bank_account_number' => '300300559',
            'image_path' => 'storage/images/tradespersonImages/connor-mckee-image.jpg',
            'logo_path' => 'storage/images/tradespersonLogos/connor-mckee-logo.jpg'
        ]);

        // Customer - 32 - 81
        for ($i = 0; $i <= 49; $i++) {
            User::create([
                'email' => $faker->unique()->safeEmail,
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'street_address' => $faker->streetAddress,
                'suburb' => $faker->city,
                'state_id' => 7,
                'postcode' => $faker->randomNumber($nbDigits = 4, $strict = true),
                'home_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'mobile_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'account_class_id' => rand(4, 9), // Plumber or Individual or Real Estate Agent or Landlord or Maintenance Manager or Shopping Centre Manager.
                'account_role_id' => 5, // Customer.
                'referral_id' => rand(2, 8),
                'user_description' => '',
                'business_name' => $faker->company,
                'abn' => $faker->randomNumber($nbDigits = 2, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true),
                'business_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'business_position' => 'Staff',
                'business_contact_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'bank_name' => $faker->word . ' Bank',
                'bank_bsb' => $faker->randomNumber($nbDigits = 3, $strict = true) . '-' . $faker->randomNumber($nbDigits = 3, $strict = true),
                'bank_account_name' => $faker->company,
                'bank_account_number' => $faker->randomNumber($nbDigits = 4, $strict = true) . $faker->randomNumber($nbDigits = 4, $strict = true),
                'business_description' => '',
            ]);
        }

        // Staff - 6 - 11
        for ($i = 0; $i <= 5; $i++) {
            User::create([
                'email' => $faker->unique()->safeEmail,
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'street_address' => $faker->streetAddress,
                'suburb' => $faker->city,
                'state_id' => 7,
                'postcode' => $faker->randomNumber($nbDigits = 4, $strict = true),
                'home_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'mobile_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'account_class_id' => 1, // Staff.
                'account_role_id' => 2, // Staff.
                'referral_id' => 1,
                'user_description' => '',
                'business_name' => $faker->company,
                'abn' => $faker->randomNumber($nbDigits = 2, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true),
                'business_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'business_position' => 'Staff',
                'business_contact_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'bank_name' => $faker->word . ' Bank',
                'bank_bsb' => $faker->randomNumber($nbDigits = 3, $strict = true) . '-' . $faker->randomNumber($nbDigits = 3, $strict = true),
                'bank_account_name' => $faker->company,
                'bank_account_number' => $faker->randomNumber($nbDigits = 4, $strict = true) . $faker->randomNumber($nbDigits = 4, $strict = true),
                'business_description' => '',
            ]);
        }



        // Tradesperson - 12 - 21
        for ($i = 0; $i <= 9; $i++) {
            User::create([
                'email' => $faker->unique()->safeEmail,
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'street_address' => $faker->streetAddress,
                'suburb' => $faker->city,
                'state_id' => 7,
                'postcode' => $faker->randomNumber($nbDigits = 4, $strict = true),
                'home_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'mobile_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'account_class_id' => 2, // Tradesperson.
                'account_role_id' => 3, // Tradesperson.
                'referral_id' => 1,
                'user_description' => '',
                'business_name' => $faker->company,
                'abn' => $faker->randomNumber($nbDigits = 2, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true),
                'business_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'business_position' => 'Staff',
                'business_contact_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'bank_name' => $faker->word . ' Bank',
                'bank_bsb' => $faker->randomNumber($nbDigits = 3, $strict = true) . '-' . $faker->randomNumber($nbDigits = 3, $strict = true),
                'bank_account_name' => $faker->company,
                'bank_account_number' => $faker->randomNumber($nbDigits = 4, $strict = true) . $faker->randomNumber($nbDigits = 4, $strict = true),
                'business_description' => '',
            ]);
        }

        // Contractor - 22 - 31
        for ($i = 0; $i <= 9; $i++) {
            User::create([
                'email' => $faker->unique()->safeEmail,
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'street_address' => $faker->streetAddress,
                'suburb' => $faker->city,
                'state_id' => 7,
                'postcode' => $faker->randomNumber($nbDigits = 4, $strict = true),
                'home_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'mobile_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'account_class_id' => rand(3, 4), // Carpenter or Plumber.
                'account_role_id' => 4, // Contractor.
                'referral_id' => 1,
                'user_description' => '',
                'business_name' => $faker->company,
                'abn' => $faker->randomNumber($nbDigits = 2, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true),
                'business_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'business_position' => 'Staff',
                'business_contact_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'bank_name' => $faker->word . ' Bank',
                'bank_bsb' => $faker->randomNumber($nbDigits = 3, $strict = true) . '-' . $faker->randomNumber($nbDigits = 3, $strict = true),
                'bank_account_name' => $faker->company,
                'bank_account_number' => $faker->randomNumber($nbDigits = 4, $strict = true) . $faker->randomNumber($nbDigits = 4, $strict = true),
                'business_description' => '',
            ]);
        }

        // Customer - 32 - 81
        for ($i = 0; $i <= 49; $i++) {
            User::create([
                'email' => $faker->unique()->safeEmail,
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'street_address' => $faker->streetAddress,
                'suburb' => $faker->city,
                'state_id' => 7,
                'postcode' => $faker->randomNumber($nbDigits = 4, $strict = true),
                'home_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'mobile_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'account_class_id' => rand(4, 9), // Plumber or Individual or Real Estate Agent or Landlord or Maintenance Manager or Shopping Centre Manager.
                'account_role_id' => 5, // Customer.
                'referral_id' => rand(2, 8),
                'user_description' => '',
                'business_name' => $faker->company,
                'abn' => $faker->randomNumber($nbDigits = 2, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true) . $faker->randomNumber($nbDigits = 3, $strict = true),
                'business_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'business_position' => 'Staff',
                'business_contact_phone' => $faker->randomNumber($nbDigits = 5, $strict = true) . $faker->randomNumber($nbDigits = 5, $strict = true),
                'bank_name' => $faker->word . ' Bank',
                'bank_bsb' => $faker->randomNumber($nbDigits = 3, $strict = true) . '-' . $faker->randomNumber($nbDigits = 3, $strict = true),
                'bank_account_name' => $faker->company,
                'bank_account_number' => $faker->randomNumber($nbDigits = 4, $strict = true) . $faker->randomNumber($nbDigits = 4, $strict = true),
                'business_description' => '',
            ]);
        }
    }
}
