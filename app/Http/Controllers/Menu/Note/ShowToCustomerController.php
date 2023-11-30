<?php

namespace App\Http\Controllers\Menu\Note;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Job;
use App\Mail\Customer\NewJobNote;
use App\Models\Note;
use Auth;
use Carbon\Carbon;

class ShowToCustomerController extends Controller
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
        // Find the required model instance.
        $selected_note = Note::findOrFail($id);
        // Secondary validation.
        // Check if the note is internal.
        if ($selected_note->is_internal != 1 || $selected_note->job_id == null) {
            // The note is not internal.
            // Return a redirect back.
            return back()
                ->with('danger', 'The selected note is already a public note that the customer can see.');
        }
        // Set The Required Variables.
        $selected_job = Job::findOrFail($selected_note->job_id);
        // Duplicate the selected note instance.
        $new_note = $selected_note->replicate();
        $new_note->is_internal = 0;
        $new_note->sender_id = Auth::id();
        $new_note->recipient_id = $selected_job->customer_id;
        $new_note->recipient_seen_at = null;
        $new_note->recipient_acknowledged_at = null;
        $new_note->jms_seen_at = Carbon::now();
        $new_note->jms_acknowledged_at = Carbon::now();
        // Store the new note in the database.
        $new_note->push();
        // Send email.
        // Check if the notify customer by email checkbox is checked and the customer has an email address.
        if ($request->notify_customer_via_email != null && $selected_job->customer->email != null) {
            // Create the data array to populate the emails with.
            $data = [
                'recipient_name' => $selected_job->customer->getFullNameAttribute(),
                'job_id' => $selected_job->id
            ];
            // Send the new job note email.
            Mail::to($selected_job->customer->email)
                ->send(new NewJobNote($data));
        }
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully shown the selected note to the customer.');
    }
}
