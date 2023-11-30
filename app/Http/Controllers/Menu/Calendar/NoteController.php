<?php

namespace App\Http\Controllers\Menu\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'text' => 'required|string|min:10|max:500'
        ]);

        // Create the new model instance.
        $new_internal_note = Note::create([
            'sender_id' => Auth::id(),
            'event_id' => $request->event_id,
            'text' => $request->text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => 1,
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'jms_seen_at' => now(),
            'jms_acknowledged_at' => now()
        ]);

        // Return a redirect to the show route.
        return redirect()
            ->route('calendar.show', $new_internal_note->event_id)
            ->with('success', 'You have successfully created a new note on the selected calendar event.');
    }
}
