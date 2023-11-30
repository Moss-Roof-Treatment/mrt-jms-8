<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\System;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        System::create([
            'title' => 'Moss Roof Treatment Pty Ltd',
            'short_title' => 'Moss Roof Treatment',
            'abn' => '33 635 776 242',
            'contact_name' => 'Stu and Deb',
            'contact_address' => 'PO BOX 79, Leopold VIC 3224',
            'contact_phone' => '1300007411',
            'default_sms_phone' => '0492821409',
            'contact_email' => 'office@mossrooftreatment.com.au',
            'website_url' => 'www.mossrooftreatment.com.au',
            'description' => 'Moss Roof Treatment',
            'acronym' => 'MRT',
            'logo_path' => 'storage/images/logos/mrt-logo.png',
            'letterhead_path' => 'storage/images/letterheads/mrt-letterhead.jpg',
            'bank_name' => 'Bendigo Bank',
            'bank_account_name' => 'Moss Roof Treatment',
            'bank_account_number' => '175524362',
            'bank_bsb_number' => '633-000',
            'default_tax_value' => 10.00,
            'default_superannuation_value' => 9.50,
        ]);
    }
}
