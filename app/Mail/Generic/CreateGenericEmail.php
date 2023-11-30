<?php

namespace App\Mail\Generic;

use App\Models\EmailAttachment;
use App\Models\System;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateGenericEmail extends Mailable
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
        $message = $this->markdown('mail.generic.create')
            ->subject($this->data['subject'])
            ->with([
                'data' => $this->data,
                'selected_system' => $selected_system
            ]);

        // Find the required attachments.
        $documents = EmailAttachment::where('email_id', $this->data['email_id'])->get();

        // Attach the selected documents.
        foreach($documents as $document) {
            $message->attach($document->storage_path); // Attach each file. 
        }

        // Send the mail.
        return $message;
    }
}
