<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Customer\StartDateChange;
use App\Models\Event;
use App\Models\Job;
use App\Models\Note;
use App\Models\System;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Nexmo\Laravel\Facade\Nexmo;

class SendJobUpdateEmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAnyStaffMember');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate The Request Data.
        $request->validate([
            'start_date' => 'required|string',
            'email_message' => 'required_with:email_check|string|min:10|max:1000',
            'sms_message' => 'required_with:sms_check|string|min:10|max:1000',
        ]);
        // Set The Required Variables.
        // Find the required job.
        $selected_job = Job::findOrFail($id);
        // Secondary Validation.
        // Check if the email checkbox is checked and if the customer has an email address.
        if (isset($request->email_check) && $selected_job->customer->email == null) {
            // The send email checkbox was set and the customer has no email address.
            return back()
                ->with('danger', 'The selected customer does not have an email address.');
        }
        // Check if the sms checkbox is checked and if the tenant has a mobile phone.
        if (isset($request->sms_check) && $selected_job->tenant_mobile_phone == null) {
            // The send sms checkbox was set and the tenant has no mobile number set.
            return back()
                ->with('danger', 'The selected tenant does not have a mobile phone.');
        }
        // Update The Job Start Date.
        $selected_job->update([
            'start_date_null' => 0,
            'start_date' => Carbon::parse($request->start_date), // Carbon parsed start date.
        ]);
        // Update The Event Date.
        // Find the required event.
        $selected_event = Event::where('job_id', $selected_job->id)->first();
        // Update the selected event.
        $selected_event->update([
            'start' => Carbon::parse($request->start_date), // Carbon parsed start date.
            'end' => Carbon::parse($request->start_date)->addHour(2), // Carbon parsed start date + 2 hours.
            'is_tradesperson_confirmed' => isset($request->is_tradesperson_confirmed) ? 1 : 0
        ]);
        // Send The Required Messages.
        // Check if the email needs to be sent.
        if (isset($request->email_check)) {
            // Create the data array to populate the email with.
            $data = [
                'recipient_name' => $selected_job->customer->getFullNameAttribute(),
                'message' => ucfirst($request->email_message), // Uppercase first word.
            ];
            // Send the email.
            Mail::to($selected_job->customer->email)
                ->send(new StartDateChange($data));
            // Create the new note.
            Note::create([
                'job_id' => $selected_job->id,
                'text' => '"Start Date Changed" email sent to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
                'is_internal' => 1,
                'jms_seen_at' => Carbon::now(),
                'jms_acknowledged_at' => Carbon::now()
            ]);
        }
        // Check if the sms needs to be sent.
        if (isset($request->sms_check)) {
            // Find the current system.
            $selected_system = System::firstOrFail(); // Moss Roof Treatment.
            // Send the sms.
            Nexmo::message()->send([
                'to'   => '61' . substr($selected_job->tenant_mobile_phone, 1), // Remove the leading 0 and add country code of '61',
                'from' => '61' . substr($selected_system->default_sms_phone, 1), // Remove the leading 0 and add country code of '61',
                'text' => 'Hello ' . $selected_job->tenant_name . ', ' . ucfirst($request->sms_message) . ' ' . $selected_system->contact_name . ' ' . $selected_system->short_title
            ]);
            // Create the new note.
            Note::create([
                'job_id' => $selected_job->id,
                'text' => 'SMS "' . ucfirst($request->sms_message) . '" sent to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
                'is_internal' => 1, // Is internal.
                'jms_seen_at' => Carbon::now(),
                'jms_acknowledged_at' => Carbon::now()
            ]);
        }
        // Create The Success Message.
        $success_text = 'You have successfully updated the start date.';
        $sms_message = isset($request->email_check) ? ' You have successfully sent the customer a sms notification.' : '';
        $email_message = isset($request->sms_check) ? ' You have successfully sent the customer an email notification.' : '';
        $success_message = $success_text . $sms_message . $email_message;
        // Return a redirect back with the success message.
        return back()
            ->with('success', $success_message);
    }
}
