<?php

namespace App\Mail\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\System;

class DepositReceipt extends Mailable
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
        // Create the email.
        return $this->markdown('mail.customers.depositReceipt')
            ->attachData($this->data['pdf_data'], $this->data['pdf_title'])
            ->with([
                'data' => $this->data,
                'selected_system' => $selected_system
            ]);
    }
}
