<?php

namespace App\Http\Controllers\Menu\Equipment;

use App\Http\Controllers\Controller;
use App\Models\EquipmentInspection;
use App\Models\EquipmentInspectionImage;
use Auth;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class InspectionImageController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Set The Required Variables.
        // Set the get variable or abort 404.
        $value = $_GET['inspection_id'] ?? abort(404);
        $inspection = EquipmentInspection::find($value);
        // Return the create view.
        return view('menu.equipment.inspections.images.create')
            ->with('inspection', $inspection);
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
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Set The Required Variables.
        $selected_inspection = EquipmentInspection::find($request->inspection_id);
        // Check if the file exists in the request data.
        if ($request->hasFile('image')) {
            // Loop through each image in the request.
            foreach($request->file('image') as $image){
                // Create the new image.
                $filename = $selected_inspection->equipment_id . '-' . $selected_inspection->id . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $location = storage_path('app/public/images/equipment/inspections/' . $filename);
                Image::make($image)->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($location);
                // Create the new model instance.
                $new_inspection_image = EquipmentInspectionImage::create([
                    'equipment_inspection_id' => $selected_inspection->id,
                    'staff_id' => Auth::id(),
                    'image_path' => 'storage/images/equipment/inspections/' . $filename,
                ]);
            }
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-inspection-images.show', $new_inspection_image->id)
            ->with('success', 'You have successfully uploaded the selected inspection image.');
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
        $selected_inspection_image = EquipmentInspectionImage::findOrFail($id);
        // Return the show view.
        return view('menu.equipment.inspections.images.show')
            ->with('selected_inspection_image', $selected_inspection_image);
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
        $selected_inspection_image = EquipmentInspectionImage::findOrFail($id);
        // Return the edit view.
        return view('menu.equipment.inspections.images.edit')
            ->with('selected_inspection_image', $selected_inspection_image);
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
            'description' => 'required|string|min:10|max:1000',
        ]);
        // Find the required model instance.
        $selected_inspection_image = EquipmentInspectionImage::findOrFail($id);
        // Update the selected model instance.
        $selected_inspection_image->upadte([
          'description' => $request->description
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-inspection-images.show', $selected_inspection_image)
            ->with('success', 'You have successfully updated the selected inspection image.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find required model instance.
        $selected_inspection_image = EquipmentInspectionImage::findOrFail($id);
        // Selected Equipment Inspection Image ID.
        $selected_equipment_inspection_id = $selected_inspection_image->equipment_inspection_id;
        // Check if the image path is not null.
        if ($selected_inspection_image->image_path != null) {
            // Delete the file from storage.
            unlink(public_path($selected_inspection_image->image_path));
        }
        // Delete the selected model instance.
        $selected_inspection_image->delete();
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-inspections.show', $selected_equipment_inspection_id)
            ->with('success', 'You have successfully deleted the selected inspection image.');
    }
}
