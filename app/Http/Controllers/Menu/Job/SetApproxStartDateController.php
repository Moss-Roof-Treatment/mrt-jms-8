<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use App\Mail\Customer\ApproxStartDateSet;
use App\Models\Job;
use App\Models\Note;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SetApproxStartDateController extends Controller
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
        $selected_job = Job::findOrFail($request->job_id);
        // Check if the selected quote customer has an email address.
        if ($selected_job->customer->email != null) {
            // Make data variable.
            $data = [
                'recipient_name' => $selected_job->customer->getFullNameAttribute(),
            ];
            // Send the email.
            Mail::to($selected_job->customer->email)
                ->send(new ApproxStartDateSet($data));
            // Create the new note.
            Note::create([
                'sender_id' => Auth::id(),
                'job_id' => $selected_job->id,
                'priority_id' => null, // No priority
                'text' => '"Approx Start Date" email sent to customer - ' . Auth::user()->getFullNameAttribute() . '.',
                'is_internal' => 1,
                'jms_seen_at' => Carbon::now(),
                'jms_acknowledged_at' => Carbon::now()
            ]);
            // Return a redirect to the job show page.
            return redirect()
                ->route('jobs.show', $selected_job->id)
                ->with('success', 'You have successfully sent a "Approx Start Date" email to the selected customer.');
        }
        // Return a redirect back.
        return back()
            ->with('warning', 'The selected user does not have an email address to send this email to.');
    }
}
