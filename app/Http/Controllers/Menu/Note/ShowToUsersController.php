<?php

namespace App\Http\Controllers\Menu\Note;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Auth;
use Carbon\Carbon;

class ShowToUsersController extends Controller
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the required model instance.
        $selected_note = Note::find($id);
        // Loop through each selected staff memeber id.
        foreach($request->staff_members as $staff_id) {
            // Duplicate the selected note instance.
            $new_note = $selected_note->replicate();
            $new_note->is_internal = 1;
            $new_note->sender_id = Auth::id();
            $new_note->recipient_id = $staff_id;
            $new_note->recipient_seen_at = null;
            $new_note->recipient_acknowledged_at = null;
            $new_note->jms_seen_at = Carbon::now();
            $new_note->jms_acknowledged_at = Carbon::now();
            // Store the new note in the database.
            $new_note->push();
        }
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully shown the selected note to the selected users.');
    }
}
