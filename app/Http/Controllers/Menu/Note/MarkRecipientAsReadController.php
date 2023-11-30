<?php

namespace App\Http\Controllers\Menu\Note;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Carbon\Carbon;

class MarkRecipientAsReadController extends Controller
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
        $selected_note = Note::findOrFail($id);
        // Update the selected model instance.
        $selected_note->update([
            'recipient_seen_at' => Carbon::now(),
            'recipient_acknowledged_at' => Carbon::now()
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully marked the selected note as read by the recipient.');
    }
}
