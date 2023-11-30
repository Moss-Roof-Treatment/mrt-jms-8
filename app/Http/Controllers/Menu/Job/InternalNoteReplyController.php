<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Staff\StaffNewNote;
use App\Models\Note;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class InternalNoteReplyController extends Controller
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

        // Set The Required Variables.
        $selected_internal_note = Note::find($request->note_id);

        // Create the new model instance.
        $new_internal_note = Note::create([
            'job_id' => $selected_internal_note->job_id,
            'sender_id' => Auth::id(),
            'recipient_id' => $selected_internal_note->recipient_id,
            'priority_id' => $selected_internal_note->priority_id ?? 4, // Low.
            'text' => $request->text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => $selected_internal_note->is_internal,
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'recipient_seen_at' => $selected_internal_note->sender_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'recipient_acknowledged_at' => $selected_internal_note->sender_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
        ]);

        // Note read status.
        // Check if the authenticated user is the recipient.
        if ($new_internal_note->recipient_id == Auth::id()) {
            // The recipient is the authenticated user.
            // Set the recipient seen at to now.
            $new_internal_note->update([
                'recipient_seen_at' => now(),
                'recipient_acknowledged_at' => now()
            ]);
        }

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

        // Return a redirect to the job show route.
        return redirect()
            ->route('jobs.show', $selected_internal_note->job_id)
            ->with('success', 'You have successfully created a new internal job note reply.');
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
        // Delete the selected model.
        $selected_internal_note_reply->delete();
        // Return redirect to the job note show page.
        return back()
            ->with('warning', 'You have successfully deleted the selected note response.');
    }
}
