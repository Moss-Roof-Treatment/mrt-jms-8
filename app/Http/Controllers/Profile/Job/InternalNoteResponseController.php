<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Staff\StaffNewNote;
use App\Models\Note;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Mail;

class InternalNoteResponseController extends Controller
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
        // Set required variables.
        // Find the required note.
        $selected_internal_note = Note::find($request->note_id);
        // Set the required quote id.
        $selected_quote_id = $request->selected_quote_id;
        // Create the new model instance.
        $new_internal_note = Note::create([
            'job_id' => $selected_internal_note->job_id,
            'sender_id' => Auth::id(),
            'recipient_id' => $selected_internal_note->recipient_id,
            'priority_id' => $selected_internal_note->priority_id ?? 4, // Low.
            'text' => $request->text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => 1, // Is Internal.
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'recipient_seen_at' => $selected_internal_note->sender_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'recipient_acknowledged_at' => $selected_internal_note->sender_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
        ]);
        // Send the new note email.
        // Check if the recipient id is not the auth id.
        if ($new_internal_note->recipient_id != null && $new_internal_note->recipient_id != Auth::id()) {
            // Find the required recipient.
            $selected_user = User::find($new_internal_note->recipient_id);
            // Create the data array to populate the emails with.
            $data = array(
                'recipient_name' => $selected_user->getFullNameAttribute(),
                'job_id' => $selected_internal_note->job_id
            );
            // Send the driveby inspection email.
            Mail::to($selected_user->email)
                ->send(new StaffNewNote($data));
        }
        // Return a redirect to the profile jobs show route.
        return redirect()
            ->route('profile-jobs.show', $selected_quote_id)
            ->with('success', 'You have successfully replied to the selected note.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // ?????????????????????????????
        // This needs to be fixed when I am not lazy.

        // Find the required model instance.
        $job_note = Note::findOrFail($id);
        // Set The Required Variables.
        $selected_quote_id = $request->selected_quote_id;
        // Delete the selected model instance.
        $job_note->delete();
        // Return a redirect to the profile job show route.
        return redirect()
            ->route('profile-jobs.show', $selected_quote_id)
            ->with('success', 'You have successfully deleted the selected note.');
    }
}
