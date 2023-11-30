<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobType;

class JobTypeController extends Controller
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
        $job_types = JobType::paginate(20);
        // Return the index view.
        return view('menu.settings.jobTypes.index')
            ->with('job_types', $job_types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.jobTypes.create');
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
            'title' => 'required|string|min:3|max:50|unique:job_types,title',
            'description' => 'required|string|min:10|max:1000',
            'procedure' => 'sometimes|nullable|string|min:10|max:1000',
        ]);
        // Create a new model instance.
        JobType::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description),
            'procedure' => ucwords($request->procedure)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('job-type-settings.index')
            ->with('success', 'You have successfully created a new job status.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required model instance.
        $selected_job_type = JobType::findOrFail($id);
        // Return the show view.
        return view('menu.settings.jobTypes.show')
            ->with('selected_job_type', $selected_job_type);
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
        $selected_job_type = JobType::findOrFail($id);
        // Return the show view.
        return view('menu.settings.jobTypes.edit')
            ->with('selected_job_type', $selected_job_type);
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
            'title' => 'required|string|min:3|max:50|unique:job_types,title,'.$id,
            'description' => 'required|string|min:10|max:1000',
            'procedure' => 'sometimes|nullable|string|min:10|max:1000',
        ]);
        // Find the required model instance.
        $selected_job_type = JobType::findOrFail($id);
        // Update the selected model instance.
        $selected_job_type->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description),
            'procedure' => ucwords($request->procedure)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('job-type-settings.index')
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
        $selected_job_type = JobType::findOrFail($id);
        // Delete the selected model instance.
        $selected_job_type->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('job-type-settings.index')
            ->with('success', 'You have successfully updated the selected job status.');
    }
}
