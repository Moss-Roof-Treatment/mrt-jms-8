<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Note;
use Auth;
use Carbon\Carbon;

class UpdateFollowUpCallStatusController extends Controller
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
        // Update the selected model instance.
        $selected_job->update([
            'follow_up_call_status_id' => $request->follow_up_call_id
        ]);
        // Create an internal job note of the status update.
        Note::create([
            'job_id' => $selected_job->id,
            'text' => '"FOLLOW UP CALL" changed to "' . $selected_job->follow_up_call_status->title . '". - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => 1,
            'jms_seen_at' => Carbon::now(),
            'jms_acknowledged_at' => Carbon::now()
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected follow up call status.');
    }
}
