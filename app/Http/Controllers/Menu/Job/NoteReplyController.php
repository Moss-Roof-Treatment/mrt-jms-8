<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Auth;
use Carbon\Carbon;

class NoteReplyController extends Controller
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
        // Validate The Request Data.
        $request->validate([
            'text' => 'required|min:10|max:2000'
        ]);
        // Find the note that is being responded to.
        $selected_public_note = Note::find($request->note_id);
        // Create the new model instance.
        $new_public_note = Note::create([
            'job_id' => $selected_public_note->job_id,
            'quote_id' => $selected_public_note->quote_id,
            'event_id' => $selected_public_note->event_id,
            'equipment_id' => $selected_public_note->equipment_id,
            'text' => $request->text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'sender_id' => Auth::id(),
            'recipient_id' => $selected_public_note->sender_id,
            'priority_id' => $selected_public_note->priority_id ?? 4, // Low.
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'recipient_seen_at' => $selected_public_note->sender_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'recipient_acknowledged_at' => $selected_public_note->sender_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('job-notes.show', $new_public_note->id)
            ->with('success', 'You have successfully created a new note.');
    }
}
