<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Staff\StaffNewNote;
use App\Models\Note;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Mail;

class CustomerNoteResponseController extends Controller
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
        // Set required variable.
        $selected_customer_note = Note::find($request->note_id);
        // Create the new model instance.
        Note::create([
            'job_id' => $selected_customer_note->job_id,
            'sender_id' => Auth::id(),
            'recipient_id' => $selected_customer_note->sender_id,
            'priority_id' => $selected_customer_note->priority_id ?? 4, // Low.
            'text' => $request->text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => $selected_customer_note->is_internal,
            'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
        ]);
        // Send the new note email.
        // Check if the recipient id is not the auth id.
        if ($selected_customer_note->recipient_id != null) {
            // Find the required recipient.
            $selected_user = User::find($selected_customer_note->recipient_id);
            // Check if the selected user email address is not null.
            if ($selected_user->email != null) { 
                // Create the data array to populate the emails with.
                $data = array(
                    'recipient_name' => $selected_user->getFullNameAttribute(),
                    'job_id' => $selected_customer_note->job_id
                );
                // Send the driveby inspection email.
                Mail::to($selected_user->email)
                    ->send(new StaffNewNote($data));
            }
        }
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully replied to the selected customer note.');
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
        $selected_internal_note_reply = Note::findOrFail($id);
        // Set The Required Variables.
        $selected_internal_note = $selected_internal_note_reply->note_id;
        // Delete the selected model instance.
        $selected_internal_note_reply->delete();
        // Return a redirect to the notes show route.
        return redirect()
            ->route('profile-job-internal-notes.show', $selected_internal_note)
            ->with('warning', 'You have successfully deleted the selected note response.');
    }
}
