<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\ExpectedPaymentMethod;
use App\Models\Job;
use App\Models\Note;
use App\Models\Quote;
use App\Models\QuoteRate;
use Auth;

class CustomerMarkAsAcceptedController extends Controller
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
            'action' => 'required'
        ]);
        // Set The Required Variables.
        // Find the required model instance.
        $selected_quote = Quote::findOrFail($id);
        // Find the required job.
        $selected_job = Job::find($selected_quote->job_id);
        // Find the required event.
        $selected_event = Event::where('job_id', $selected_job->id)
            ->first();
        // Find the expected payment method.
        $selected_expected_payment_method = ExpectedPaymentMethod::find($request->action);

        // Check what value has been entered. 
        if (in_array($request->action, [2,3,4])) { // Will pay: 2 = card, 3 = bank, 4 = cheque.
            // Set the deposit pending statuses.
            // Update the selected model instance.
            $selected_quote->update([
                'deposit_accepted_date' => null, // This is null because the yellow buttons need to still be visible.
                'quote_status_id' => 4, // Sold (Deposit Pending).
                'expected_payment_method_id' => $selected_expected_payment_method->id
            ]);
            // Update the selected job.
            $selected_job->update([
                'job_status_id' => 4, // Sold (Deposit Pending).
                'sold_date' => null // The sold date needs to be null due to a pending deposit.
            ]);
            // Set note details.
            $payment_note_text = 'Quote "#' . $selected_quote->quote_identifier . '" has been marked as accepted by staff. ' . $selected_expected_payment_method->title;
            $status_note_text = '"JOB STATUS" changed to "Sold (Deposit Pending)".';

        } elseif (in_array($request->action, [5,6,7])) { // Paid: 5 = card, 6 = bank, 7 = cheque.

            // Set the deposit pay on completion statuses.
            // Update the selected model instance.
            $selected_quote->update([
                'deposit_accepted_date' => now(), // The quote has been accepted by the customer.
                'quote_status_id' => 3, // Sold (Deposit Paid).
                'expected_payment_method_id' => $selected_expected_payment_method->id
            ]);
            // Update the selected job.
            $selected_job->update([
                'job_status_id' => 5, // Sold (Deposit Paid).
                'sold_date' => now() // this needs to be set for 'on completion' or 'paid'.
            ]);
            // Set note details.
            $payment_note_text = 'Quote "#' . $selected_quote->quote_identifier . '" has been marked as accepted by staff. ' . $selected_expected_payment_method->title;
            $status_note_text = '"JOB STATUS" changed to "Sold (Deposit Paid)".';

        } elseif (in_array($request->action, [8,9,10,11])) { // Pay on completion: 8 = card, 9 = cash, 10 = bank, 11 = cheque.

            // Set the deposit pay on completion statuses.
            // Update the selected model instance.
            $selected_quote->update([
                'deposit_accepted_date' => now(), // The quote has been accepted by the customer.
                'quote_status_id' => 5, // Sold (Payment On Completion).
                'expected_payment_method_id' => $selected_expected_payment_method->id
            ]);
            // Update the selected job.
            $selected_job->update([
                'job_status_id' => 6, // Sold (Payment On Completion).
                'sold_date' => now() // this needs to be set for 'on completion' or 'paid'.
            ]);
            // Set note details.
            $payment_note_text = 'Quote "#' . $selected_quote->quote_identifier . '" has been marked as accepted by staff. ' . $selected_expected_payment_method->title;
            $status_note_text = '"JOB STATUS" changed to "Sold (Payment On Completion)".';

        } else { // No selected action, catch all other inputs.

            // Return a redirect with error message. 
            return back()
                ->with('danger', 'No input was selected, please select an input and try again.');
        }

        // Update The Calendar Event.
        // The calendar event may not have the quote_id set, so set it now that the deposit has been paid.
        $selected_event = Event::where('job_id', $selected_quote->job_id)
            ->first();
        // Check if the event exists.
        if($selected_event != null) {
            // The event exists.
            // Update the quote id on the event.
            $selected_event->update([
                'quote_id' => $selected_quote->id 
            ]);
        }

        // Make the new note model instances.
        // Create payment note.
        Note::create([
            'job_id' => $selected_quote->job_id,
            'priority_id' => 2, // Important. 
            'is_internal' => 1, // Is Internal.
            'text' => $payment_note_text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
        ]);
        // Create status note.
        Note::create([
            'job_id' => $selected_quote->job_id,
            'is_internal' => 1, // Is Internal.
            'text' => $status_note_text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
        ]);

        // Update the event object.
        $selected_event->update([
            'quote_id' => $selected_quote->id,
            'color' => $selected_job->job_status->color,
            'textColor' => $selected_job->job_status->text_color,
            'description' => $payment_note_text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
        ]);

        // Update all other quotes to not given.
        // Find all other quotes related to this job.
        $all_quotes = Quote::where('job_id', $selected_quote->job_id)
            ->where('id', '!=', $selected_quote->id)
            ->get();
        // Check if the all quotes variable is not null.
        if ($all_quotes != null) {
            // Loop through each quote and set them to not given.
            foreach($all_quotes as $selected_quote) {
                // Set the quote status id to not given.
                $selected_quote->quote_status_id = 8; // Not Given.
                $selected_quote->save();
                // Garbage Collection.
                $selected_quote->garbageCollection();
                // Find all job flags from this quote. 
                $selected_job_flags = QuoteRate::where('quote_id', $selected_quote->id)
                    ->get();
                // Loop through each of the job flags.
                foreach($selected_job_flags as $flag) {
                    // Update the selected job flag.
                    $flag->update([
                        'staff_id' => null
                    ]);
                }
            }
        }

        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully marked the selected quote as accepted for the customer.');
    }
}
