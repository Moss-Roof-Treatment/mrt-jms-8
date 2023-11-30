<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InspectionType;

class InspectionTypeController extends Controller
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
        $inspection_types = InspectionType::paginate(20);

        // Return the index view.
        return view('menu.settings.inspectionTypes.index')
            ->with('inspection_types', $inspection_types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.inspectionTypes.create');
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
            'title' => 'required|min:5|max:255|unique:inspection_types,title',
            'description' => 'required|min:15|max:255',
        ]);
        // Create the new model instance.
        InspectionType::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('inspection-type-settings.index')
            ->with('success', 'You have successfully created a new inspection type.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $selected_inspection_type = InspectionType::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.inspectionTypes.edit')
            ->with('selected_inspection_type', $selected_inspection_type);
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
            'title' => 'required|min:5|max:255|unique:inspection_types,title,'.$id,
            'description' => 'required|min:15|max:255',
        ]);
        // Find the required model instance.
        $elected_inspection_type = InspectionType::findOrFail($id);
        // Update the selected model instance.
        $elected_inspection_type->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('inspection-type-settings.index')
            ->with('success', 'You have successfully updated the selected inspection type.');
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
        $elected_inspection_type = InspectionType::findOrFail($id);
        // Delete the selected model instance.
        $elected_inspection_type->delete();
        // Return a redirect to index route.
        return redirect()
            ->route('inspection-type-settings.index')
            ->with('success', 'You have successfully deleted the selected inspection type.');
    }
}
