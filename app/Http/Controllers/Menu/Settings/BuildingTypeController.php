<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuildingType;

class BuildingTypeController extends Controller
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
        $building_types = BuildingType::paginate(20);
        // Return the index view.
        return view('menu.settings.buildingTypes.index')
            ->with('building_types', $building_types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.buildingTypes.create');
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
            'title' => 'required|min:5|max:255|unique:building_types,title',
            'description' => 'required|min:20|max:255',
        ]);
        // Create the new model instance.
        BuildingType::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('building-type-settings.index')
            ->with('success', 'You have successfully created a new building type.');
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
        $selected_building_type = BuildingType::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.buildingTypes.edit')
            ->with('selected_building_type', $selected_building_type);
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
            'title' => 'required|min:5|max:255|unique:building_types,title,'.$id,
            'description' => 'required|min:20|max:255',
        ]);
        // Find the required model instance.
        $selected_building_type = BuildingType::findOrFail($id);
        // Update the selected model instance.
        $selected_building_type->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('building-type-settings.index')
            ->with('success', 'You have successfully updated the selected building type.');
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
        $selected_building_type = BuildingType::findOrFail($id);
        // Delete the selected model instance.
        $selected_building_type->delete();
        // Return a redirect to index route.
        return redirect()
            ->route('building-type-settings.index')
            ->with('success', 'You have successfully deleted the selected building type.');
    }
}
