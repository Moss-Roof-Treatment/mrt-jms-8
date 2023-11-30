<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Job;
use App\Models\JobStatus;
use App\Models\Note;
use Auth;
use Carbon\Carbon;

class UpdateQuoteSentStatusController extends Controller
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
        // Find the required job.
        $selected_job = Job::findOrFail($id);
        // Update the status and save the job.
        $selected_job->update([
            'quote_sent_status_id' => $request->quote_sent_id
        ]);
        // Update the required event.
        // Set The Required Variables.
        $selected_event = Event::where('job_id', $selected_job->id)
            ->first();
        // Check if the selected event is not null.
        if ($selected_event != null) {
            // Set The Required Variables.
            $selected_job_status = JobStatus::find(3); // Pending
            // Update the selected event.
            $selected_event->update([
                'title' => $selected_job->id . '-' . $selected_job->tenant_suburb,
                'description' => 'The quote sent status has been manually updated to set using the update quote sent status dropdown on the view selected job page.',
                'color' => $selected_job_status->color,
                'textColor' => $selected_job_status->text_color
            ]);
        }
        // Create an internal job note of the status update.
        Note::create([
            'job_id' => $selected_job->id,
            'text' => '"QUOTE SENT STATUS" changed to "' . $selected_job->quote_sent_status->title . '". - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => 1,
            'jms_seen_at' => Carbon::now(),
            'jms_acknowledged_at' => Carbon::now()
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected quote sent status.');
    }
}
