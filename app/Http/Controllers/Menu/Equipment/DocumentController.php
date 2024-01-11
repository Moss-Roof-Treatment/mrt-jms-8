<?php

namespace App\Http\Controllers\Menu\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentDocument;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DocumentController extends Controller
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
    public function create(Request $request)
    {
        // Set the get variable or abort 404.
        $value = $_GET['equipment_id'] ?? abort(404);
        // Set The Required Variables.
        $equipment = Equipment::findOrFail($value);
        // Return the create view.
        return view('menu.equipment.documents.create')
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
            'title' => 'required|unique:equipment_documents,title',
            'description' => 'nullable|string',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            "document" => 'sometimes|nullable|file|mimes:pdf|max:3072', // 3MB
        ]);
        // Create a new model instance.
        $new_document = EquipmentDocument::create([
            'equipment_id' => $request->equipment_id,
            'title' => $request->title,
            'description' => $request->description
        ]);
        // Create the new image if required.
        if ($request->hasFile('image')) {
            // Create the image.
            $image = $request->file('image');
            $filename = Str::slug($new_document->title) . '-image' . '.' . $image->getClientOriginalExtension();
            $location = storage_path('app/public/images/equipment/documents/' . $filename);
            Image::make($image)->orientate()->save($location);
            // Update the selected model instance.
            $new_document->update([
                'image_path' => 'storage/images/equipment/documents/' . $filename
            ]);
        }
        // Create the new logo if required.
        if (!$request->document == null) {
            // Create the logo.
            $document = $request->file('document');
            $filename = Str::slug($new_document->title) . '-' . time() . '.' . $document->getClientOriginalExtension();
            $location = storage_path('app/public/documents/equipment/');
            $document->move($location, $filename);
            // Update the selected model instance.
            $new_document->update([
                'document_path' => 'storage/documents/equipment/' . $filename
            ]);
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment.show', $new_document->equipment_id)
            ->with('success', 'You have successfully created the new equipment document.');
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
        $document = EquipmentDocument::findOrFail($id);
        // Return the show view.
        return view('menu.equipment.documents.show')
            ->with('document', $document);
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
        $document = EquipmentDocument::findOrFail($id);
        // Return the edit view.
        return view('menu.equipment.documents.edit')
            ->with('document', $document);
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
            'title' => 'required|unique:equipment_documents,title,'.$id,
            'description' => 'nullable|string',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            "document" => 'sometimes|nullable|file|mimes:pdf|max:3072', // 3MB
        ]);
        // Find the required model instance.
        $selected_document = EquipmentDocument::findOrFail($id);
        // Update the selected model instance.
        $selected_document->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        // Replace the stored image if required.
        if (isset($request->image)){
            // Delete the old file from storage.
            if ($selected_document->image_path != null) {
                if (file_exists(public_path($selected_document->image_path))) {
                    unlink(public_path($selected_document->image_path));
                }
            }
            // Create the new image.
            $image = $request->file('image');
            $filename = Str::slug($selected_document->title) . '-image' . '.' . $image->getClientOriginalExtension();
            $location = storage_path('app/public/images/equipment/documents/' . $filename);
            Image::make($image)->orientate()->save($location);
            // Update the selected model instance.
            $selected_document->update([
                'image_path' => 'storage/images/equipment/documents/' . $filename
            ]);
        }
        // Replace the stored document if required.
        if (isset($request->document)){
            // Delete the old file from storage.
            if ($selected_document->document_path != null) {
                if (file_exists(public_path($selected_document->document_path))) {
                    unlink(public_path($selected_document->document_path));
                }
            }
            // Create the new image.
            $document = $request->file('document');
            $filename = Str::slug($selected_document->title) . '-document' . '.' . $document->getClientOriginalExtension();
            $location = storage_path('app/public/documents/equipment/');
            $document->move($location, $filename);
            // Update the selected model instance.
            $selected_document->update([
                'document_path' => 'storage/documents/equipment/' . $filename
            ]);
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-documents.show', $id)
            ->with('success', 'You have successfully edited the selected equipment document.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required equipment document.
        $selected_document = EquipmentDocument::findOrFail($id);
        // Selected Equipment ID.
        $selected_equipment_id = $selected_document->equipment_id;
        // Delete the image of the selected equipment document.
        if ($selected_document->image_path != null) {
            if (file_exists(public_path($selected_document->image_path))) {
                unlink(public_path($selected_document->image_path));
            }
        }
        // Delete the document of the selected equipment document.
        if ($selected_document->document_path != null) {
            if (file_exists(public_path($selected_document->document_path))) {
                unlink(public_path($selected_document->document_path));
            }
        }
        // Delete the selected model instance,
        $selected_document->delete();
        // Return a redirect tothe equipment show route.
        return redirect()
            ->route('equipment.show', $selected_equipment_id)
            ->with('success', 'You have successfully deleted the selected equipment document.');
    }
}
