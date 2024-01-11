<?php

namespace App\Http\Controllers\Menu\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentInspection;
use Carbon\Carbon;

class InspectionController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set the get variable or abort 404.
        $value = $_GET['equipment_id'] ?? abort(404);
        // Set The Required Variables.
        $equipment = Equipment::findOrFail($value);
        // Return the create view.
        return view('menu.equipment.inspections.create')
            ->with('equipment', $equipment);
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
            'inspection_date' => 'required|date',
            'inspection_company' => 'required|string|min:5|max:100',
            'inspector_name' => 'required|string|min:5|max:100',
            'tag_and_test_id' => 'sometimes|nullable|min:3|max:20',
            'text' => 'required|string|min:10|max:500',
            'next_inspection_date' => 'sometimes|nullable|date'
        ]);

        // dd($request->equipment_id);

        // Create a new model instance.
        $new_inspection = EquipmentInspection::create([
            'equipment_id' => 1,
            'inspection_date' => $request->inspection_date,
            'inspection_company' => ucwords($request->inspection_company),
            'inspector_name' => ucwords($request->inspector_name),
            'tag_and_test_id' => $request->tag_and_test_id,
            'text' => $request->text,
            'next_inspection_date' => $request->next_inspection_date
        ]);

        // dd('here');

        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-inspections.show', $new_inspection->id)
            ->with('success', 'You have successfully created a new equipment inspection. Please upload any ralevent images if required.');
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
        $inspection = EquipmentInspection::findOrFail($id);
        // Return the show view.
        return view('menu.equipment.inspections.show')
            ->with('inspection', $inspection);
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
        $inspection = EquipmentInspection::findOrFail($id);
        // Get substring of date for date field.
        $inspection_date = substr($inspection->inspection_date, 0, 10);
        // Get substring of date for date field.
        $next_inspection_date = substr($inspection->next_inspection_date, 0, 10);
        // Return the show view.
        return view('menu.equipment.inspections.edit')
            ->with([
                'inspection' => $inspection,
                'inspection_date' => $inspection_date,
                'next_inspection_date' => $next_inspection_date
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
            'inspection_date' => 'required',
            'inspection_company' => 'required|string|min:5|max:100',
            'inspector_name' => 'required|string|min:5|max:100',
            'tag_and_test_id' => 'sometimes|nullable|min:3|max:20',
            'text' => 'required|string|min:10|max:500',
            'next_inspection_date' => 'required'
        ]);
        // Find and update the selected model instance.
        $inspection = EquipmentInspection::findOrFail($id);
        // Update the selected model instance. 
        $inspection->update([
            'inspection_date' => Carbon::parse($request->inspection_date)->startOfDay(),
            'inspection_company' => $request->inspection_company,
            'inspector_name' => $request->inspector_name,
            'tag_and_test_id' => $request->tag_and_test_id,
            'text' => $request->text,
            'next_inspection_date' => Carbon::parse($request->next_inspection_date)->startOfDay()
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-inspections.show', $inspection->id)
            ->with('success', 'You have successfully updated the selected inspection.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find and delete the selected model instance and relationships.
        $selected_inspection = EquipmentInspection::findOrFail($id);
        // Selected Equipment ID.
        $selected_equipment_id = $selected_inspection->equipment_id;
        // Check if the selected model instance has any image relationships.
        if ($selected_inspection->images != null) {
            // Loop through each image.
            foreach($selected_inspection->images as $image) {
                // Delete the image from storage.
                unlink(public_path($image->image_path));
                // Delete the image model instance.
                $image->delete();
            }
        }
        // Delete the selected model insatance.
        $selected_inspection->delete();
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment.show', $selected_equipment_id)
            ->with('success', 'You have successfully deleted the selected equipment inspection.');
    }
}
