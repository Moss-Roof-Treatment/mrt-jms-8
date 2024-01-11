<?php

namespace App\Http\Controllers\Menu\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EquipmentInspection;
use App\Models\EquipmentInspectionImage;
use Auth;
use Intervention\Image\Facades\Image;
use Session;

class InspectionDropzoneController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Set The Required Variables.
        $selected_inspection = EquipmentInspection::findOrFail($request->inspection_id);
        // Check if the file exists in the request data.
        if ($request->hasFile('file')) {
            // Create the new image.
            $image = $request->file('file');
            $filename = $selected_inspection->equipment_id . '-' . $selected_inspection->id . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $location = storage_path('app/public/images/equipment/inspections/' . $filename);
            Image::make($image)->orientate()->resize(1280, 720)->save($location);
            // Create the new model instance.
            $new_inspection_image = EquipmentInspectionImage::create([
                'equipment_inspection_id' => $selected_inspection->id,
                'staff_id' => Auth::id(),
                'image_path' => 'storage/images/equipment/inspections/' . $filename,
            ]);
        }
        // Set the flash message in the session.
        Session::flash('success', 'You have successfully uploaded the selected inspection image(s).');
    }
}
