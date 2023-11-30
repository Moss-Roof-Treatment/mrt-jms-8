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

class UpdateJobStatusController extends Controller
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
        $selected_job = Job::findOrFail($id);
        // Set The Required Variables.
        // Find the entered job status.
        $selected_job_status = JobStatus::find($request->job_status_id);

        // Update the selected model instance.
        switch ($request->input('job_status_id')) {

            case '4': // Sold (Deposit Pending).
                // Update the job status.
                $selected_job->update([
                    'job_status_id' => 4, // Sold (Deposit Pending).
                    'sold_date' => null // Set null.
                ]);
            break;

            case '5': // Sold (Deposit Paid).
                // Update the job status.
                $selected_job->update([
                    'job_status_id' => 5, // Sold (Deposit Paid).
                    'sold_date' => Carbon::now() // Timestamp now.
                ]);
            break;

            case '6': // Sold (Payment On Completion).
                // Update the job status.
                $selected_job->update([
                    'job_status_id' => 6, // Sold (Payment On Completion).
                    'sold_date' => Carbon::now() // Timestamp now.
                ]);
            break;

            case '7': // Completed.
                // Update the job status.
                $selected_job->update([
                    'job_status_id' => 7, // Completed.
                    'completion_date' => $selected_job->completion_date == null ? Carbon::now() : $selected_job->completion_date,
                    'sold_date' => $selected_job->sold_date == null ? Carbon::now() : $selected_job->sold_date
                ]);
            break;

            default: // All others.
                // Set the input value without any other required action.
                $selected_job->update([            
                    'job_status_id' => $selected_job_status->id
                ]);
        }

        // Update the required event.
        // Set The Required Variables.
        $selected_event = Event::where('job_id', $selected_job->id)->first();
        // Check if the selected event is not null.
        if ($selected_event != null) {
            // Update the selected event.
            $selected_event->update([
                'description' => 'The job status has been manually updated to ' . $selected_job_status->title . ' using the update job status dropdown on the view selected job page.',
                'color' => $selected_job_status->color,
                'textColor' => $selected_job_status->text_color
            ]);
        }
        // Create an internal job note of the status update.
        Note::create([
            'job_id' => $selected_job->id,
            'text' => '"JOB STATUS" manually changed to "' . $selected_job->job_status->title . '" - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => 1,
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'jms_seen_at' => Carbon::now(),
            'jms_acknowledged_at' => Carbon::now(),
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected job status.');
    }
}
