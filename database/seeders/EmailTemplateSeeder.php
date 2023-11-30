<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | Actions Emails.
        |--------------------------------------------------------------------------
        */

        EmailTemplate::create([
            'id' => 1,
            'title' => 'Contractor To Quote Email',
            'subject' => 'Contractor To Quote',
            'text' => 'Can you please contact this customer and arrange a quote.',
            'class_name' => '\App\Mail\Contractor\ContractorToQuote',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 2,
            'title' => 'Approximate Start Date',
            'subject' => 'Approximate Start Date',
            'text' => "Your Moss Roof Treatment job has been acknowledged and an estimated start date has been appointed. As the applications of our product are weather dependent, one of our applicators will contact you prior to this approximated start date to confirm if it is to go ahead or be changed. We thank you for your involvement and hope you are happy with our services. Any further questions, please don't hesitate to contact our office.",
            'class_name' => '\App\Mail\Customer\ApproxStartDateSet',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 3,
            'title' => 'Deposit Recieved Email',
            'subject' => 'Deposit Recieved',
            'text' => 'We have received your deposit - thank you very much. Please feel free to contact us if you have any questions.',
            'class_name' => '\App\Mail\Customer\DepositReceived',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 4,
            'title' => 'Final Receipt Email',
            'subject' => 'Final Receipt',
            'text' => 'Our team thank you for your payment. We hope that you will recommend us to family and friends.',
            'class_name' => '\App\Mail\Customer\FinalReceipt',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 5,
            'title' => 'New Job Images Uploaded',
            'subject' => 'New Job Images',
            'text' => 'New job images have been uploaded to your job.',
            'class_name' => '\App\Mail\Customer\NewJobImages',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 6,
            'title' => 'New Job Note Created',
            'subject' => 'New Job Note',
            'text' => 'New job notes have been uploaded to your job.',
            'class_name' => '\App\Mail\Customer\NewJobNote',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 7,
            'title' => 'Online Quote Access Email',
            'subject' => 'Online Quote Access',
            'text' => 'Thank you for the opportunity to quote your roof, we have just started a new on-line system which lets you view all photos before, during and after works are completed. Plus a direct messaging system to the office for any questions and all pdf documents to view. Please take the time to view the system and if you have any questions please contact us via the messaging service.',
            'class_name' => '\App\Mail\Customer\OnlineQuoteAccess',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 8,
            'title' => 'Paid Receipt Email',
            'subject' => 'Paid Receipt',
            'text' => 'Our team thank you for your payment. We hope that you will recommend us to family and friends.',
            'class_name' => '\App\Mail\Customer\PaidReceipt',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 9,
            'title' => 'Tax Invoice Email',
            'subject' => 'Tax Invoice',
            'text' => 'Your updated tax invoice is attached, Payment methods are included. Prompt payment as per our terms & conditions would be appreciated. We thank you for your business.',
            'class_name' => '\App\Mail\Customer\TaxInvoice',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 10,
            'title' => 'Tradesperson Assigned Email',
            'subject' => 'Tradesperson Assigned',
            'text' => 'Your job has now been allocated to one of our trades persons. You can view their profile via the self service portal. They will endeavor to contact you within 2-3 working days to introduce themself.',
            'class_name' => '\App\Mail\Customer\TradespersonAssigned',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 11,
            'title' => 'Work Order Email',
            'subject' => 'Work Order',
            'text' => 'Thank you for accepting our quote. Please login to view the work order and terms & conditions PDF in your administration section. Please click the accept button within the online system and then pay a 25% deposit to lock in your start date. There is a choice of payment methods, Please follow the instructions online. When paying online please use your work order number as the reference. Please feel free to contact me if you have any questions.',
            'class_name' => '\App\Mail\Customer\WorkOrderContract',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generic Email.
        |--------------------------------------------------------------------------
        */

        EmailTemplate::create([
            'id' => 12,
            'title' => 'Generic Email',
            'class_name' => '\App\Mail\Generic\CreateGenericEmail',
            'is_groupable' => 1,
            'is_editable' => 0,
            'is_delible' => 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notifications Emails.
        |--------------------------------------------------------------------------
        */

        EmailTemplate::create([
            'id' => 15,
            'title' => 'Staff New Internal Note',
            'subject' => 'New Internal Note',
            'text' => 'A new internal job note have been uploaded to a job you are working on.',
            'class_name' => '\App\Mail\Staff\StaffNewNote',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 16,
            'title' => 'Staff New Job Flag',
            'subject' => 'New Job Flag',
            'text' => 'A new job flag has been set.',
            'class_name' => '\App\Mail\Staff\StaffNewFlag',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 17,
            'title' => 'Staff New Message',
            'subject' => 'New Message',
            'text' => 'A new message has been received.',
            'class_name' => '\App\Mail\Staff\StaffNewMessage',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Send PDF Quote Email.
        |--------------------------------------------------------------------------
        */

        EmailTemplate::create([
            'id' => 18,
            'title' => 'Send Quote PDF Email',
            'subject' => 'MRT Quote PDF',
            'text' => 'Thank you for the opportunity to quote your roof, Attached to this email is a PDF copy of your quote for you to download and view.',
            'class_name' => '\App\Mail\Customer\SendQuotePDFEmail',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Send PDF Quote Email.
        |--------------------------------------------------------------------------
        */

        EmailTemplate::create([
            'id' => 19,
            'title' => 'Automatic Quote Reminder',
            'subject' => 'MRT Quote Reminder',
            'text' => 'We are sending a quick email to see how our quote is going. If you could please find the time to give us a response by clicking on one of the characters below and following the prompts it would be much appreciated.',
            'class_name' => '\App\Mail\Customer\AutomaticQuoteReminder',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 20,
            'title' => 'Discount Online Quote Access Email',
            'subject' => 'Discounted Moss Roof Treatment Quote',
            'text' => 'We are re-visiting some of our previous quotes as we are conducting work in your area. We have updated and discounted your quote for you to view on our new online system. Please take the time to view the system and if you have any questions please contact us via the messaging service.',
            'class_name' => '\App\Mail\Generic\CreateGenericEmail',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);

        EmailTemplate::create([
            'id' => 21,
            'title' => 'Start Date Changed Email',
            'subject' => 'Start Date Changed',
            'text' => 'PENDING PENDING PENDING.',
            'class_name' => '\App\Mail\Customer\StartDateChange',
            'is_groupable' => 0,
            'is_editable' => 1,
            'is_delible' => 0,
        ]);
    }
}
