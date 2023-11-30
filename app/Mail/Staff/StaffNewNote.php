<?php

namespace App\Mail\Staff;

use App\Models\EmailTemplate;
use App\Models\System;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffNewNote extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The data variable.
     *
     * @var $data
     */
    public $data;

    /**
     * Create a new notification instance.
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
        $selected_email_template = EmailTemplate::find(15); // Staff New Internal Note.
        // Create the email.
        return $this->markdown('mail.staff.newInternalNote')
            ->subject($selected_email_template->subject)
            ->with([
                'data' => $this->data,
                'selected_email_template' => $selected_email_template,
                'selected_system' => $selected_system
            ]);
    }
}
