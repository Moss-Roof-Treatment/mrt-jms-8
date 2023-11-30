<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobStatus;

class JobStatusController extends Controller
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
    public function index()
    {
        // Find all of the required model instances.
        $job_statuses = JobStatus::paginate(20);
        // Return the index view.
        return view('menu.settings.jobStatus.index')
            ->with('job_statuses', $job_statuses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.jobStatus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'title' => 'required|string|min:3|max:50|unique:job_statuses',
            'color' => 'required|string|min:7|max:7',
            'description' => 'sometimes|nullable|string|min:3|max:255',
        ]);
        // Set The Required Variables.
        // Set the event colour.
        $event_color = $request->color;
        // FORMAT HEX COLOUR.
        // Set the RGB Values.
        $r = hexdec(substr($event_color, 1, 2));
        $g = hexdec(substr($event_color, 3, 2));
        $b = hexdec(substr($event_color, 5, 2));
        // Calculate YIQ colour space.
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        // Set the text colour based on the calculated value.
        if ($yiq >= 128) {
            $text_color = '#000000'; // Black
        } else {
            $text_color = '#ffffff'; // White
        }
        // Create a new model instance.
        JobStatus::create([
            'title' => ucwords($request->title),
            'calendar_title' => ucwords($request->title),
            'color' => $event_color,
            'text_color' => $text_color,
            'description' => ucwords($request->description),
            'is_editable' => 1
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('job-status-settings.index')
            ->with('success', 'You have successfully created a new job status.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the required model instance.
        $selected_job_status = JobStatus::findOrFail($id);
        // Return the show view.
        return view('menu.settings.jobStatus.edit')
            ->with('selected_job_status', $selected_job_status);
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
            'title' => 'required|string|min:3|max:50|unique:job_statuses,title,'.$id,
            'color' => 'required|string|min:7|max:7',
            'description' => 'sometimes|nullable|string|min:3|max:255',
        ]);

        // Set the event colour.
        $event_color = $request->color;
        // FORMAT HEX COLOUR.
        // Set the RGB Values.
        $r = hexdec(substr($request->color, 1, 2));
        $g = hexdec(substr($request->color, 3, 2));
        $b = hexdec(substr($request->color, 5, 2));
        // Calculate YIQ colour space.
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        // Set the text colour based on the calculated value.
        if ($yiq >= 128) {
            $text_color = '#000000'; // Black
        } else {
            $text_color = '#ffffff'; // White
        }
        // Find the required model instance.
        $selected_job_status = JobStatus::findOrFail($id);
        // Set The Required Variables.
        // Check if the new colour is the same as the old one.
        $update_status_colours = $selected_job_status->color == $request->color ? true : false;

        // Update the selected model instance.
        $selected_job_status->update([
            'title' => ucwords($request->title),
            'calendar_title' => ucwords($request->title),
            'color' => $request->color,
            'text_color' => $text_color,
            'description' => ucwords($request->description),
            'is_editable' => 1
        ]);

        // Update The Colours
        // Check if the colours need updating.
        if ($update_status_colours == false) {
            // Find all jobs
            $all_jobs = Job::all();
            // Loop through each job.
            foreach ($all_jobs as $job) {
                // Update the event.
                $job->event()->update([
                    'color' => $job->job_status->color,
                ]);
            }
        }

        // Return a redirect to the index route.
        return redirect()
            ->route('job-status-settings.index')
            ->with('success', 'You have successfully updated the selected job status.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required model instance.
        $selected_job_status = JobStatus::findOrFail($id);
        // Delete the selected model instance.
        $selected_job_status->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('job-status-settings.index')
            ->with('success', 'You have successfully updated the selected job status.');
    }
}
