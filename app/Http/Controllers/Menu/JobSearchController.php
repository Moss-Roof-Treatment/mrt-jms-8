<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class JobSearchController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'job_id' => 'required'
        ]);
        // Find the required model instance.
        $selected_job = Job::find($request->job_id);
        // Check if there is a job found.
        if (!isset($selected_job)) {
            // Job does not exist.
            // Return a redirect back
            return back()
                ->with('warning', 'There is no job that matches the job number that you have entered.');
        } else {
            // Job exists.
            // Return a redirect to the jobs show route.
            return redirect()
                ->route('jobs.show', $selected_job->id);
        }
    }
}
