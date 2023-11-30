<?php

namespace App\Http\Controllers\Profile\Note;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Auth;
use Carbon\Carbon;

class NoteMarkAsReadController extends Controller
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find all of the required model instances.
        $selected_note = Note::findOrFail($id);
        // Update the selected model instance.
        // Check if the recipient is the authenticated user.
        if ($selected_note->recipient_id == Auth::id()) {
            // Check if the note recipient acknowledged at data is null.
            if ($selected_note->recipient_acknowledged_at == null) {
                // Set the note acknowledged date to now.
                $selected_note->update([
                    'recipient_seen_at' => Carbon::now(),
                    'recipient_acknowledged_at' => Carbon::now()
                ]);
            } else {
                // Set the note acknowledged date to null.
                $selected_note->update([
                    'recipient_acknowledged_at' => null
                ]);
            }
        }
        // Return a redirect to the profile notes index route.
        return redirect()
            ->route('profile-notes.index')
            ->with('success', 'You have successfully toggled the selected note acknowledged status.');
    }
}
