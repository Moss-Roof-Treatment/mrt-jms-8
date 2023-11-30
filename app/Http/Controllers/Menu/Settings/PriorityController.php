<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colour;
use App\Models\Priority;

class PriorityController extends Controller
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
        $all_priorities = Priority::paginate(20);
        // Return the index view.
        return view('menu.settings.priorities.index')
            ->with('all_priorities', $all_priorities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        $all_colours = Colour::all();
        // Return the create view.
        return view('menu.settings.priorities.create')
            ->with('all_colours', $all_colours);
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
            'title' => 'required|string|min:3|max:50|unique:priorities',
            'resolution_amount' => 'required',
            'resolution_period' => 'required',
            'colour' => 'required',
        ]);
        // Create a new model instance.
        Priority::create([
            'title' => ucwords($request->title),
            'resolution_amount' => $request->resolution_amount,
            'resolution_period' => ucfirst($request->resolution_period),
            'colour_id' => $request->colour
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('priority-settings.index')
            ->with('success', 'You have successfully created a new priority.');
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
        $selected_priority = Priority::findOrFail($id);
        // Set The Required Variables.
        $all_colours = Colour::all();
        // Return the show view.
        return view('menu.settings.priorities.edit')
            ->with([
                'all_colours' => $all_colours,
                'selected_priority' => $selected_priority
            ]);
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
            'title' => 'required|string|min:3|max:50|unique:priorities,title,'.$id,
            'resolution_amount' => 'required',
            'resolution_period' => 'required',
            'colour' => 'required',
        ]);
        // Find the required model instance.
        $selected_priority = Priority::findOrFail($id);
        // Update the selected model instance.
        $selected_priority->update([
            'title' => ucwords($request->title),
            'resolution_amount' => $request->resolution_amount,
            'resolution_period' => ucfirst($request->resolution_period),
            'colour_id' => $request->colour
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('priority-settings.index')
            ->with('success', 'You have successfully updated the selected priority.');
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
        $selected_priority = Priority::findOrFail($id);
        // Delete the selected model instance.
        $selected_priority->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('priority-settings.index')
            ->with('success', 'You have successfully updated the selected priority.');
    }
}
