<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobProgress;

class JobProgressController extends Controller
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
        $job_progresses = JobProgress::paginate(20);
        // Return the index view.
        return view('menu.settings.jobProgress.index')
            ->with('job_progresses', $job_progresses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.jobProgress.create');
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
            'title' => 'required|string|min:3|max:50|unique:job_progresses',
            'description' => 'sometimes|nullable|string|min:3|max:255',
        ]);
        // Create a new model instance.
        JobProgress::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('job-progress-settings.index')
            ->with('success', 'You have successfully created a new job progress.');
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
        $selected_job_progress = JobProgress::findOrFail($id);
        // Return the show view.
        return view('menu.settings.jobProgress.edit')
            ->with('selected_job_progress', $selected_job_progress);
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
            'title' => 'required|string|min:3|max:50|unique:job_progresses,title,'.$id,
            'description' => 'sometimes|nullable|string|min:3|max:255',
        ]);
        // Find the required model instance.
        $selected_job_progress = JobProgress::findOrFail($id);        
        // Update the selected model instance.
        $selected_job_progress->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('job-progress-settings.index')
            ->with('success', 'You have successfully updated the selected job progress.');
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
        $selected_job_progress = JobProgress::findOrFail($id);
        // Delete the selected model instance.
        $selected_job_progress->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('job-progress-settings.index')
            ->with('success', 'You have successfully updated the selected job progress.');
    }
}
