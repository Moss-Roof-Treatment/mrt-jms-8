<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\SmsTemplate;
use App\Models\User;
use App\Models\System;
use Auth;
use Carbon\Carbon;
use Nexmo\Laravel\Facade\Nexmo;

class SendSmsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isStaff');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'sms_to_send' => 'required',
        ]);

        // Set The Required Variables. 
        // Find the required customer.
        $selected_customer = User::find($request->selected_customer_id);
        // Find the required sms template.
        $selected_sms_template = SmsTemplate::find($request->sms_to_send);
        // Find the current system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.

        // Secondary validation.
        if ($selected_customer->mobile_phone == null) {
            // The mobile number is null.
            // Return redirect back with error message.
            return back()
                ->with('danger', 'The selected customer does not have a mobile number.');
        }

        // Send the sms.
        Nexmo::message()->send([
            'to'   => '61' . substr($selected_customer->mobile_phone, 1), // Remove the leading 0 and add country code of '61',
            'from' => '61' . substr($selected_system->default_sms_phone, 1), // Remove the leading 0 and add country code of '61',
            'text' => 'Hello ' . $selected_customer->first_name . ', ' . $selected_sms_template->text . ' ' . $selected_system->contact_name . ' ' . $selected_system->short_title
        ]);

        // Create the new note.
        Note::create([
            'job_id' => $request->selected_job_id,
            'text' => 'SMS "' . $selected_sms_template->title . '" sent to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => 1, // Is internal.
            'jms_seen_at' => Carbon::now(),
            'jms_acknowledged_at' => Carbon::now()
        ]);

        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully sent the selected sms.');
    }
}
