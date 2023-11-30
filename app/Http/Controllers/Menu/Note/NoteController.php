<?php

namespace App\Http\Controllers\Menu\Note;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountRole;
use App\Models\Note;
use App\Models\User;
use Auth;
use Carbon\Carbon;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Set The Required Variables.
        // All account roles.
        $all_account_roles = AccountRole::all('id', 'title');
        // Return the index view.
        return view('menu.notes.index')
            ->with('all_account_roles', $all_account_roles);
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
        $selected_note = Note::findOrFail($id);
        // Update the selected model instance.
        // Set the seen date and time.
        $selected_note->update([
            'jms_seen_at' => Carbon::now()
        ]);
        // Set The Required Variables.
        // All staff users.
        $all_staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->whereNotIn('id', [1,Auth::id()]) // Not the first user or the authenticated user.
            ->where('login_status_id', 1) // 1 = Is Active.
            ->with('account_role')
            ->get();
        // Return the note view.
        return view('menu.notes.show')
            ->with([
                'selected_note' => $selected_note,
                'all_staff_members' => $all_staff_members,
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
        // Find the required model instance.
        $selected_note = Note::findOrFail($id);
        // Update the selected model instance.
        // Check if the selected note is acknowledged. 
        if ($selected_note->jms_acknowledged_at == null) {
            // The selected note is not acknowledged.
            // Check if seen at is null.
            if ($selected_note->jms_seen_at == null) {
                // The seen date is null.
                // Set both seen and acknowledged date and time.
                $selected_note->update([
                    'jms_seen_at' => Carbon::now(),
                    'jms_acknowledged_at' => Carbon::now()
                ]);
            } else {
                // The seen date is not null.
                // Set acknowledged date and time.
                $selected_note->update([
                    'jms_acknowledged_at' => Carbon::now()
                ]);
            }
        } else {
            // The selected note is acknowledged.
            // Set acknowledged date to null.
            $selected_note->update([
                'jms_acknowledged_at' => null
            ]);
        }
        // Return a redirect back.
        return redirect()
            ->route('notes.show', $id)
            ->with('success', 'You have successfull updated the acknowledgement status of the selected note.');
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
        $note = Note::findOrFail($id);
        // Soft delete the selected model instance.
        $note->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('notes.index')
            ->with('success', 'You have successfully trashed the selected note.');
    }
}
