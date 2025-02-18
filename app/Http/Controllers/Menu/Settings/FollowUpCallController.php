<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colour;
use App\Models\FollowUpCallStatus;

class FollowUpCallController extends Controller
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
        $all_follow_up_call_statuses = FollowUpCallStatus::orderBy('colour_id')->get();
        // Return the index view.
        return view('menu.settings.followUpCallStatuses.index')
            ->with('all_follow_up_call_statuses', $all_follow_up_call_statuses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Get the required colours.
        $all_colours = Colour::whereIn('id', [2, 3, 4, 7])
            ->get();
        // Return the create view.
        return view('menu.settings.followUpCallStatuses.create')
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
            'colour' => 'required',
            'title' => 'required|min:5|max:100|unique:follow_up_call_statuses,title',
            'description' => 'required|min:15|max:255',
        ]);
        // Create the new model instance.
        FollowUpCallStatus::create([
            'colour_id' => $request->colour,
            'title' => ucwords($request->title),
            'description' => ucwords($request->description),
            'is_selectable' => $request->is_selectable == 1 ? 1 : 0
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('follow-up-call-settings.index')
            ->with('success', 'You have successfully created a new follow up call status.');
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
        $selected_follow_up_call_status = FollowUpCallStatus::findOrFail($id);
        // Set The Required Variables.
        // Get the required colours.
        $all_colours = Colour::whereIn('id', [2, 3, 4, 7])
            ->get();
        // Return the edit view.
        return view('menu.settings.followUpCallStatuses.edit')
            ->with([
                'all_colours' => $all_colours,
                'selected_follow_up_call_status' => $selected_follow_up_call_status
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
            'colour' => 'required',
            'title' => 'required|min:3|max:100|unique:follow_up_call_statuses,title,' . $id,
            'description' => 'sometimes|nullable|min:20|max:255',
        ]);
        // Find the required model instance.
        $selected_follow_up_call_status = FollowUpCallStatus::findOrFail($id);
        // Update the selected model instance.
        $selected_follow_up_call_status->update([
            'colour_id' => $request->colour,
            'title' => ucwords($request->title),
            'description' => ucwords($request->description),
            'is_selectable' => $request->is_selectable == 1 ? 1 : 0
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('follow-up-call-settings.index')
            ->with('success', 'You have successfully updated the selected follow up call status.');
    }
}
