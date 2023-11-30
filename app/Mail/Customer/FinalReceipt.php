<?php

namespace App\Mail\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\System;
use App\Models\EmailTemplate;

class FinalReceipt extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The data variable.
     *
     * @var $data
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Set the system variables.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Set the email template.
        $selected_email_template = EmailTemplate::find(4); // Final Receipt.
        // Create the email.
        return $this->markdown('mail.customers.finalReceipt')
            ->subject($selected_email_template->subject)
            ->with([
                'data' => $this->data,
                'selected_email_template' => $selected_email_template,
                'selected_system' => $selected_system
            ]);
    }
}
