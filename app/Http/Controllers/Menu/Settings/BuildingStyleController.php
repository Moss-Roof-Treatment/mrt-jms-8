<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuildingStyle;

class BuildingStyleController extends Controller
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
        $building_styles = BuildingStyle::get();
        // Return the index view.
        return view('menu.settings.buildingStyles.index')
            ->with('building_styles', $building_styles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.buildingStyles.create');
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
            'title' => 'required|min:5|max:255|unique:building_styles,title',
            'description' => 'required|min:20|max:255',
        ]);
        // Create the new model instance.
        BuildingStyle::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('building-style-settings.index')
            ->with('success', 'You have successfully created a new building style.');
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
        $selected_building_style = BuildingStyle::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.buildingStyles.edit')
            ->with('selected_building_style', $selected_building_style);
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
            'title' => 'required|min:5|max:255|unique:building_styles,title,'.$id,
            'description' => 'required|min:20|max:255',
        ]);
        // Find the required model instance.
        $selected_building_style = BuildingStyle::findOrFail($id);
        // Update the selected model instance.
        $selected_building_style->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('building-style-settings.index')
            ->with('success', 'You have successfully updated the selected building style.');
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
        $selected_building_style = BuildingStyle::findOrFail($id);
        // Delete the selected model instance.
        $selected_building_style->delete();
        // Return a redirect to index route.
        return redirect()
            ->route('building-style-settings.index')
            ->with('success', 'You have successfully deleted the selected building style.');
    }
}
