<?php

namespace App\Http\Controllers\Menu\Note;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class AllowTradesToViewController extends Controller
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
            'profile_job_can_see' => $selected_note->profile_job_can_see == 1 ? 0 : 1
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully toggled the tradespersons to view status.');
    }
}
