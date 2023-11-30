<?php

namespace App\Http\Controllers\Menu\Equipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Note;
use App\Models\Priority;
use Auth;

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
        // Find the required equipment using the session variable.
        $equipment = Equipment::find(session('selected_equipment_id'));
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
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment.show', $new_note->equipment_id)
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
        $note = Note::findOrFail($id);

        if (session()->has('selected_equipment_note_id')) {
            session()->pull('selected_equipment_note_id');
        }

        session([
            'selected_equipment_note_id' => $note->id,
        ]);
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
        $selected_note->priority_id = $request->priority_id ?? 4; // Low.
        $selected_note->text = ucfirst($request->text);
        $selected_note->save();
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
        // Check if the images relationship is not null.
        if ($selected_note->images != null) {
            // Loop through each image relationship.
            foreach($selected_note->images as $image) {
                // Delete the file from storage.
                unlink(public_path($image->image_path));
                // Delete the model relationship instance.
                $image->delete();
            }
        }
        // Delete the selected model instance.
        $selected_note->delete();
        // Return a redirect to the show route.
        return redirect()
            ->route('equipment.show', session('selected_equipment_id'))
            ->with('success', 'You have successfully deleted the selected equipment note.');
    }
}
