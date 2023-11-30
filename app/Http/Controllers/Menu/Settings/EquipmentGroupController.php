<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EquipmentGroup;

class EquipmentGroupController extends Controller
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
        $all_equipment_groups = EquipmentGroup::paginate(20);
        // Return the index view.
        return view('menu.settings.equipmentGroups.index')
            ->with('all_equipment_groups', $all_equipment_groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.equipmentGroups.create');
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
            'title' => 'required|string|min:3|max:80',
            'description' => 'required|string|min:10|max:1000',
        ]);
        // Create the new model instance.
        $new_equipment_group = EquipmentGroup::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);

        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-group-settings.show', $new_equipment_group->id)
            ->with('success', 'You have successfully created a new equipment group.');
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
        $selected_equipment_group = EquipmentGroup::findOrFail($id);
        // Return the show view.
        return view('menu.settings.equipmentGroups.show')
            ->with('selected_equipment_group', $selected_equipment_group);
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
        $selected_equipment_group = EquipmentGroup::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.equipmentGroups.edit')
            ->with('selected_equipment_group', $selected_equipment_group);
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
            'title' => 'required|string|min:3|max:80',
            'description' => 'required|string|min:10|max:1000',
        ]);
        // Find the required model instance.
        $selected_equipment_group = EquipmentGroup::findOrFail($id);
        // Update the selected model instance.
        $selected_equipment_group->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-group-settings.show', $selected_equipment_group->id)
            ->with('success', 'You have successfully updated the selected equipment category.');
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
        $selected_equipment_group = EquipmentGroup::findOrFail($id);
        // Validate delible status.
        if ($selected_equipment_group->equipments()->exists()) {
            // Return a redirect back.
            return back()
                ->with('danger', 'You cannot delete the selected equipment group as it curretly has equipment in it.');
        }
        // Delete the selected model instance.
        $selected_equipment_group->delete();
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-group-settings.index')
            ->with('success', 'You have successfully deleted the selected equipment group.');
    }
}
