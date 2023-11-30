<?php

namespace App\Http\Controllers\Profile\Note;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Auth;

class NoteResponseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAnyStaffMember');
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
            'text' => 'required|min:10|max:2000'
        ]);
        // Find the note that is being responded to.
        $selected_public_note = Note::find($request->note_id);
        // Create the new model instance.
        // Create new note.
        Note::create([
            'job_id' => $selected_public_note->job_id,
            'quote_id' => $selected_public_note->quote_id,
            'event_id' => $selected_public_note->event_id,
            'equipment_id' => $selected_public_note->equipment_id,
            'text' => $request->text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'sender_id' => Auth::id(),
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'recipient_id' => $selected_public_note->sender_id,
            'is_internal' => $selected_public_note->is_internal,
            'priority_id' => $selected_public_note->priority_id ?? 4, // Low.
            'recipient_seen_at' => $selected_public_note->sender_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'recipient_acknowledged_at' => $selected_public_note->sender_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
        ]);
        // Return a redirect back.
        return redirect()
            ->route('profile-notes.index')
            ->with('success', 'You have successfully create a replied to the selected note.');
    }
}
