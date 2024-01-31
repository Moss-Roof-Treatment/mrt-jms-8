<?php

namespace App\Http\Controllers\Menu\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Note;
use App\Models\NoteImage;
use App\Models\Priority;
use Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class NoteController extends Controller
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
        // Set The Required Variables.
        // Set the get variable or abort 404.
        $value = $_GET['equipment_id'] ?? abort(404);
        // Set The Required Variables.
        $equipment = Equipment::findOrFail($value);
        // Find all Priorities.
        $priorities = Priority::all('id', 'title');
        // Return the create view.
        return view('menu.equipment.notes.create')
            ->with([
                'equipment' => $equipment,
                'priorities' => $priorities
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
            'text' => 'required|string|min:10|max:500',
        ]);
        // Create a new model instance.
        $new_note = Note::create([
            'sender_id' => Auth::id(),
            'equipment_id' => $request->equipment_id,
            'priority_id' => $request->priority_id ?? 4, // Low.
            'text' => ucfirst($request->text) . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
        ]);
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new strorage path for the database.
            $storage_location = 'storage/images/equipment/notes/' . $filename;
            // Set the new file location.
            $location = public_path($storage_location);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->toJpeg(80)->save($location);
            // Create the new model instance.
            NoteImage::create([
                'note_id' => $new_note->id,
                'image_path' => $storage_location,
            ]);
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-items.show', $new_note->equipment_id)
            ->with('success', 'You have successfully created a new equipment note.');
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
        $note = Note::with('note_images')
            ->findOrFail($id);
        // Return the show view.
        return view('menu.equipment.notes.show')
            ->with('note', $note);
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
        $note = Note::findOrFail($id);
        // Set The Required Variables.
        // Find all Priorities.
        $priorities = Priority::all('id', 'title');
        // Return the show view.
        return view('menu.equipment.notes.edit')
            ->with([
                'note' => $note,
                'priorities' => $priorities
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
            'text' => 'required|string|min:10|max:500',
        ]);
        // Find and update the selected model instance.
        $selected_note = Note::findOrFail($id);
        // Update the selected note.
        $selected_note->update([
            'priority_id' => $request->priority_id ?? 4,
            'text' => $request->text,
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-notes.show', $selected_note->id)
            ->with('success', 'You have successfully updated the selected note.');
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
        $selected_note = Note::findOrFail($id);
        // Selected Equipment ID.
        $selected_equipment_id = $selected_note->equipment_id;
        // Check if the selected model instance has any image relationships.
        if ($selected_note->images != null) {
            // Loop through each image.
            foreach($selected_note->images as $image) {
                if($image->image_path && file_exists(public_path($image->image_path))) {
                    // Delete the image from storage.
                    unlink(public_path($image->image_path));
                }
                // Delete the image model instance.
                $image->delete();
            }
        }
        // Delete the selected model instance.
        $selected_note->delete();
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment-items.show', $selected_equipment_id)
            ->with('success', 'You have successfully deleted the selected equipment note.');
    }
}
