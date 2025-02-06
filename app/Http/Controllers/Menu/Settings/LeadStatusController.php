<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use App\Models\Colour;
use App\Models\LeadStatus;
use Illuminate\Http\Request;

class LeadStatusController extends Controller
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
        $all_lead_statuses = LeadStatus::all();
        // Return the index view.
        return view('menu.settings.leadStatuses.index')
            ->with('all_lead_statuses', $all_lead_statuses);
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
        return view('menu.settings.leadStatuses.create')
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
            'title' => 'required|min:5|max:100|unique:lead_statuses,title',
            'description' => 'required|min:15|max:255',
        ]);
        // Create the new model instance.
        LeadStatus::create([
            'colour_id' => $request->colour,
            'title' => ucwords($request->title),
            'description' => ucwords($request->description),
            'is_selectable' => $request->is_selectable == 1 ? 1 : 0
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('customer-lead-statuses.index')
            ->with('success', 'You have successfully created a new lead status.');
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
        $selected_lead_status = LeadStatus::findOrFail($id);
        // Set The Required Variables.
        // Get the required colours.
        $all_colours = Colour::whereIn('id', [2, 3, 4])
            ->get();
        // Return the edit view.
        return view('menu.settings.leadStatuses.edit')
            ->with([
                'all_colours' => $all_colours,
                'selected_lead_status' => $selected_lead_status
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
            'title' => 'required|min:3|max:100|unique:lead_statuses,title,' . $id,
            'description' => 'sometimes|nullable|min:20|max:255',
        ]);
        // Find the required model instance.
        $selected_lead_status = LeadStatus::findOrFail($id);
        // Update the selected model instance.
        $selected_lead_status->update([
            'colour_id' => $request->colour,
            'title' => ucwords($request->title),
            'description' => ucwords($request->description),
            'is_selectable' => $request->is_selectable == 1 ? 1 : 0
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('customer-lead-statuses.index')
            ->with('success', 'You have successfully updated the selected lead status.');
    }
}
