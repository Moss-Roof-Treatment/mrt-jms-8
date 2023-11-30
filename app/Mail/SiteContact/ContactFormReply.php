<?php

namespace App\Mail\SiteContact;

use App\Models\System;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormReply extends Mailable
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
        // The email content.
        return $this->markdown('mail.siteContact.create')
            ->from($this->data['sender_email'])
            ->subject('Site Contact Response')
            ->with([
                'data' => $this->data,
                'selected_system' => $selected_system,
            ]);
    }
}
