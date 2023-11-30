<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Note;
use Auth;
use Carbon\Carbon;

class UpdateJobProgressStatusController extends Controller
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
        // Find the required job.
        $selected_job = Job::findOrFail($id);
        // Update the status and save the job.
        $selected_job->update([
            'job_progress_id' => $request->progress_id
        ]);
        // Create an internal job note of the status update.
        Note::create([
            'job_id' => $selected_job->id,
            'text' => '"JOB PROGRESS" changed to "' . $selected_job->job_progress->title . '" - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => 1,
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'jms_seen_at' => Carbon::now(),
            'jms_acknowledged_at' => Carbon::now()
        ]);
        // Return a redirect to the job show route.
        return back()
            ->with('success', 'You have successfully updated the selected job progress status.');
    }
}
