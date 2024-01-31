<?php

namespace App\Http\Controllers\Menu\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EquipmentInspection;
use App\Models\EquipmentInspectionImage;
use Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Session;
use Illuminate\Support\Str;

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
        // Check the request data for the required file.
        if ($request->hasFile('file')) {
            // Set the uploaded file.
            $image = $request->file('file');
            // Set the new file name.
            $filename = Str::slug($selected_inspection->equipment_id . ' ' . $selected_inspection->id . ' ' . uniqid()) . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/equipment/inspections/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(1280, 720)->toJpeg(80)->save($location);
            // Create the new model instance.
            EquipmentInspectionImage::create([
                'equipment_inspection_id' => $selected_inspection->id,
                'staff_id' => Auth::id(),
                'image_path' => 'storage/images/equipment/inspections/' . $filename,
            ]);
        }
        // Set the flash message in the session.
        Session::flash('success', 'You have successfully uploaded the selected inspection image(s).');
    }
}
