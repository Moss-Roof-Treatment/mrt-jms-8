<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SmsTemplate;

class SmsTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SmsTemplate::create([
            'id' => 1,
            'title' => 'Generic SMS', 
            'is_groupable' => 1,
            'is_editable' => 0,
            'is_delible' => 0,
        ]);

        SmsTemplate::create([
            'id' => 2,
            'title' => 'Delivery Test SMS',
            'text' => 'This is a delivery test message for the Qontrol Core sms service.', 
            'is_groupable' => 1,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        SmsTemplate::create([
            'id' => 3,
            'title' => 'Quote Follow Up SMS',
            'text' => 'It’s the team from Moss Roof Treatment here. Just checking in with you regarding the quote we sent you. Any questions or concerns? Let us know.', 
            'is_groupable' => 1,
            'is_editable' => 1,
            'is_delible' => 1,
        ]);

        SmsTemplate::create([
            'id' => 4,
            'title' => 'Check Spam Folder SMS',
            'text' => 'It’s the team from Moss Roof Treatment here. Just checking in to see if you have received an email so you can log in to view your quote. If this has not appeared in your inbox , please check your spam/junk folder or alternatively search for Moss Roof Treatment.', 
            'is_groupable' => 1,
            'is_editable' => 1,
            'is_delible' => 1,
        ]);

        SmsTemplate::create([
            'id' => 5,
            'title' => 'Online Username/ Password Access SMS',
            'text' => 'It’s the team from Moss Roof Treatment here. Just checking in to see if you received an email from us yet. If not, here is the link with your log in details to help. www.mossrooftreatment.com.au/login Username: is your email. Password : is your first and last name, one word all lowercase, no spaces. Let us know how you go.',
            'is_groupable' => 1,
            'is_editable' => 1,
            'is_delible' => 1,
        ]);

        SmsTemplate::create([
            'id' => 6,
            'title' => 'No LATR Quote But MRT Available',
            'text' => 'Look At This Roof is unable to provide a quote for roof repairs due to Covid-19 affecting our tradesmen and staff capabilities. We have provided a quote for Moss Roof Treatment which is a user-friendly, water-based & bio-degradable product that is applied to roof surfaces to kill moss, mould & lichen and keep the moss/spores away for longer. This quote has been sent to your email. Apologies for the inconvenience.',
            'is_groupable' => 1,
            'is_editable' => 1,
            'is_delible' => 1,
        ]);

        SmsTemplate::create([
            'id' => 7,
            'title' => 'GMAIL Promotional Folder Check',
            'text' => 'We have emailed your quote. Please double check the "Promotional" tab on your Gmail inbox as our email may have been shifted into this inbox. If you do not receive the quote email within 2-3 days from previous contact with MRT, please ring the office.', 
            'is_groupable' => 1,
            'is_editable' => 1,
            'is_delible' => 1,
        ]);

        SmsTemplate::create([
            'id' => 8,
            'title' => 'Customer Comeback Inspection Reply',
            'text' => 'Thank you for sending through the photos of your roof, I can see from the images supplied that the moss has changed colour, is curling at the edges and looks dry.... this indicates that the treatment has penetrated the moss and it is dead. With all treatments we allow 12-18 months for full results. At this stage we feel that there is no need for any further action to occur as the treatment is performing as intended.', 
            'is_groupable' => 1,
            'is_editable' => 1,
            'is_delible' => 1,
        ]);

        SmsTemplate::create([
            'id' => 9,
            'title' => 'Start Date Change',
            'text' => 'Due to the change in fluid situation, we will have to rearrange your start date and time of the application of Moss Roof Treatment. Sorry for any inconvenience.',
            'is_groupable' => 1,
            'is_editable' => 1,
            'is_delible' => 1,
        ]);
    }
}
