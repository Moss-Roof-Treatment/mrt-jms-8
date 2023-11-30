<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Customer\OnlineQuoteAccess;
use App\Models\Event;
use App\Models\EmailTemplate;
use App\Models\JobStatus;
use App\Models\Note;
use App\Models\Quote;
use App\Models\System;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendOnlineQuoteAccessEmailController extends Controller
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
        // Set The Required Variables.
        // Find the required quote.
        $selected_quote = Quote::find($request->quote_id);
        // Find the required customer.
        $selected_customer = User::find($selected_quote->customer_id);
        // Find the required system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Set the email subject.
        $email_subject = ucfirst($request->subject);
        // Set the email text.
        $email_text = ucfirst($request->message);
        // GENERATE A PASSWORD
        // Set the available characters string.
        $chars = "abcdefghmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        // Shuffle the characters string and trim the first 8 characters.
        $random_string = substr(str_shuffle($chars),0,8);
        // Update the selected quote model instance.
        // Check if the quote status is 1 (new).
        if ($selected_quote->quote_status_id == 1) {
            $selected_quote->update([
                'quote_status_id' => 2 // Pending.
            ]);
        }
        // Update the job model instance.
        // Check if the job status is <= 2 (quote request or new).
        if ($selected_quote->job->job_status_id <= 2) {
            // Find the required job status.
            $selected_job_status = JobStatus::find(3); // Pending.
            // Update the job status to 3 (pending).
            $selected_quote->job->update([
                'job_status_id' => $selected_job_status->id // 3 - Pending.
            ]);
            // Find the required event model instance.
            $selected_event = Event::where('job_id', $selected_quote->job_id)
                ->first();
                // Check if the selected event does not equal null.
            if ($selected_event != null) {
                // Update the selected event.
                $selected_event->update([
                    'description' => 'The job status has been automatically updated to ' . $selected_job_status->title . ' by clicking on the send online quote access button',
                    'color' => $selected_job_status->color,
                    'textColor' => $selected_job_status->text_color
                ]);
            }
        }
        // Update the selected user model instance.
        $selected_customer->update([
          'password' => bcrypt($random_string), // Random string of characters.
          'has_login_details' => 1 // 1 = has been sent login details. 
        ]);
        // Create new welcome email.
        // Check if the selected quote customer has an email address.
        if ($selected_customer->email != null) {
            // Create the data array to populate the email with.
            $data = [
                'recipient_name' => $selected_customer->getFullNameAttribute(),
                'username' => $selected_customer->email,
                'password' => $random_string,
                'subject' => $email_subject,
                'message' => $email_text,
            ];
            // Set the required email template.
            $selected_email_template = EmailTemplate::find(7); // Online quote access email.
            // Check if the message text is the same as the template text.
            if ($selected_email_template->text != $email_text) {
                // Create a new note of the text.
                Note::create([
                    'job_id' => $selected_quote->job_id,
                    'text' => 'Custom online email text sent to customer: ' . $email_text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
                    'is_internal' => 1,
                    'jms_seen_at' => Carbon::now(),
                    'jms_acknowledged_at' => Carbon::now()
                ]);
            }
            // Send the email.
            Mail::to($selected_customer->email)
                ->send(new OnlineQuoteAccess($data));
            // Create the new note.
            Note::create([
                'job_id' => $selected_quote->job_id,
                'text' => '"Online Quote Access" email sent to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
                'is_internal' => 1,
                'jms_seen_at' => Carbon::now(),
                'jms_acknowledged_at' => Carbon::now()
            ]);
            // Return a redirect with the success message.
            return redirect()
                ->route('quotes.show', $selected_quote->id)
                ->with('success', 'You have successfully sent the selected customer a new online quote access email and set the quote status to pending.');
        }
        // Return a redirect to the quote show route.
        return redirect()
            ->route('quotes.show', $selected_quote->id)
            ->with('warning', 'The selected customer does not have an email address to send this email to. The quote status has been updated to pending.');
    }
}
