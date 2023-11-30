<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialType;

class MaterialTypeController extends Controller
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
        $types = MaterialType::paginate(20);
        // Return the index view.
        return view('menu.settings.materialTypes.index')
            ->with('types', $types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.materialTypes.create');
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
            'title' => 'required|string|min:4|max:80',
            'description' => 'required|string|min:10|max:255',
            'mpa_coverage' => 'required|string',
        ]);
        // Create the new model instance.
        MaterialType::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description),
            'mpa_coverage' => $request->mpa_coverage
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('material-type-settings.index')
            ->with('success', 'You have successfully created a new roof surface.');
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
        $selected_material_type = MaterialType::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.materialTypes.edit')
            ->with('selected_material_type', $selected_material_type);
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
            'title' => 'required|string|min:4|max:80',
            'description' => 'required|string|min:10|max:255',
            'mpa_coverage' => 'required|string',
        ]);
        // Find the required model instance.
        $selected_material_type = MaterialType::findOrFail($id);
        // Update the selected model instance.
        $selected_material_type->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description),
            'mpa_coverage' => $request->mpa_coverage
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('material-type-settings.index')
            ->with('success', 'You have successfully updated the selected roof surface.');
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
        $selected_material_type = MaterialType::findOrFail($id);
        // Delete the selected model instance.
        $selected_material_type->delete();
        // Return a redirect to index route.
        return redirect()
            ->route('material-type-settings.index')
            ->with('success', 'You have successfully deleted the selected roof surface.');
    }
}
