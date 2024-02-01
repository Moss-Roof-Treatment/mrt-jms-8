<?php

namespace App\Http\Controllers\Menu\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentGroup;
use App\Models\EquipmentDocument;
use App\Models\EquipmentInspection;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class EquipmentController extends Controller
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
        $all_equipment = Equipment::orderBy('id', 'desc')->paginate(20);
        // Return the index view.
        return view('menu.equipment.items.index')
            ->with('all_equipment', $all_equipment);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Find all equipment categories.
        $all_categories = EquipmentCategory::all('id', 'title');
        // Find all equipment groups.
        $all_groups = EquipmentGroup::all('id', 'title');
        // All staff users.
        $staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('id', '!=', 1) // Not the first user in the database.    
            ->where('login_status_id', 1) // 1 = Is Active.
            ->with('account_role')
            ->get();
        // Return the create view.
        return view('menu.equipment.items.create')
            ->with([
                'all_categories' => $all_categories,
                'all_groups' => $all_groups,
                'staff_members' => $staff_members
            ]);
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
            'title' => 'required|min:5|max:255|unique:equipment,title',
            'brand' => 'sometimes|nullable|string|min:5|max:255|',
            'serial_number' => 'required|string|min:5|max:255|',
            'equipment_category_id' => 'sometimes|nullable',
            'equipment_group_id' => 'sometimes|nullable',
            'owner' => 'sometimes|nullable|integer',
            'description' => 'required|string|min:5|max:500|',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Create a new model instance.
        $equipment = Equipment::create([
            'title' => ucwords($request->title),
            'brand' => ucwords($request->brand),
            'serial_number' => $request->serial_number,
            'equipment_category_id' => $request->equipment_category_id,
            'equipment_group_id' => $request->equipment_group_id,
            'owner_id' => $request->owner_id,
            'description' => ucwords($request->description)
        ]);
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/equipment/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $equipment->update([
                'image_path' => 'storage/images/equipment/' . $filename
            ]);
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-items.show', $equipment->id)
            ->with('success', 'You have successfully created the new equipment.');
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
        $equipment = Equipment::findOrFail($id);
        // Set The Required Variables.
        // All equipment inspections.
        $equipment_inspections = EquipmentInspection::where('equipment_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        // All equipment notes.
        $equipment_notes = Note::where('equipment_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        // All equipment documents.
        $equipment_documents = EquipmentDocument::where('equipment_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        // Return the show view.
        return view('menu.equipment.items.show')
            ->with([
                'equipment' => $equipment,
                'equipment_inspections' => $equipment_inspections,
                'equipment_notes' => $equipment_notes,
                'equipment_documents' => $equipment_documents
            ]);
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
        $selected_equipment = Equipment::findOrFail($id);
        // Set The Required Variables.
        // Find all equipment categories.
        $all_categories = EquipmentCategory::all('id', 'title');
        // Find all equipment groups.
        $all_groups = EquipmentGroup::all('id', 'title');
        // All staff users.
        $staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('id', '!=', 1) // Not the first user in the database.
            ->with('account_role')
            ->get();
        // Return the edit view.
        return view('menu.equipment.items.edit')
            ->with([
                'selected_equipment' => $selected_equipment,
                'all_categories' => $all_categories,
                'all_groups' => $all_groups,
                'staff_members' => $staff_members
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
        // Validate the request data and set equipment variable.
        $request->validate([
            'title' => 'required|min:5|max:255|unique:equipment,title,'.$id,
            'brand' => 'sometimes|nullable|string|min:5|max:255|',
            'serial_number' => 'required|string|min:5|max:255|',
            'equipment_category_id' => 'sometimes|nullable',
            'equipment_group_id' => 'sometimes|nullable',
            'owner' => 'sometimes|nullable|integer',
            'description' => 'required|string|min:5|max:500|',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Find the required model instance
        $equipment = Equipment::findOrFail($id);
        // Update the selected model instance.
        $equipment->update([
            'title' => ucwords($request->title),
            'brand' => ucwords($request->brand),
            'serial_number' => $request->serial_number,
            'equipment_category_id' => $request->equipment_category_id,
            'equipment_group_id' => $request->equipment_group_id,
            'owner_id' => $request->owner_id,
            'description' => ucwords($request->description)
        ]);
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Check if the file path value is not null and file exists on the server.
            if ($equipment->image_path != null && file_exists(public_path($equipment->image_path))) {
                // Delete the file from the server.
                unlink(public_path($equipment->image_path));
            }
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/equipment/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $equipment->update([
                'image_path' => 'storage/images/equipment/' . $filename
            ]);
        }
        // Return a redirect to the show view.
        return redirect()
            ->route('equipment-items.show', $equipment->id)
            ->with('success', 'You have successfully edited the selected equipment.');
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
        $equipment = Equipment::findOrFail($id);
        // Delete the inspections and images of the selected equipment.
        if ($equipment->equipment_inspections()->exists() != null) {
            foreach($equipment->equipment_inspections as $inspection) {
                foreach($inspection->images as $image) {
                    if ($image->image_path != null && file_exists(public_path($image->image_path))) {
                        unlink(public_path($image->image_path));
                    }
                    $image->delete();
                }
                // dd('inspection time');
                $inspection->delete();
            }
        }

        // dd('inspections section complete');

        // Delete the notes and images of the selected equipment.
        if ($equipment->notes()->exists() != null) {
            foreach($equipment->notes as $note) {
                foreach($note->note_images as $image) {
                    if ($image->image_path != null && file_exists(public_path($image->image_path))) {
                        unlink(public_path($image->image_path));
                    }
                    $image->delete();
                }
                // dd('note time');
                $note->delete();
            }
        }
        
        // dd('notes section complete');

        // Delete the document and images of the selected equipment.
        if ($equipment->equipment_documents()->exists() != null) {
            foreach ($equipment->equipment_documents as $document) {
                if ($document->image_path != null && file_exists(public_path($document->image_path))) {
                    unlink(public_path($document->image_path));
                }
                if ($document->document_path != null && file_exists(public_path($document->document_path))) {
                    unlink(public_path($document->document_path));
                }
                // dd('document time');
                $document->delete();
            }
        }
        
        // dd('all items done');
        // dd('inspections section complete');

        // Delete the selected equipment item and return a redirect to equipment index page.
        if ($equipment->image_path != null && file_exists(public_path($equipment->image_path))) {
            unlink(public_path($equipment->image_path));   
        }
        // Delete the selected model instance.
        $equipment->delete();
        // Return redirect to the index route.
        return redirect()
            ->route('equipment-items.index')
            ->with('success', 'You have successfully deleted the selected equipment.');
    }
}
