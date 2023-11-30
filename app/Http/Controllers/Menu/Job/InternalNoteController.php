<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Note;
use App\Mail\Staff\StaffNewNote;
use App\Models\Priority;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class InternalNoteController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Find the required job.
        $job = Job::find($_GET['job_id']);
        // Get all Priorities.
        $priorities = Priority::all('id', 'title');
        // All staff users.
        $recipients = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->whereNotIn('id', [1,Auth::id()]) // Not the first user or the authenticated user.
            ->with('account_role')
            ->get();
        // Return the create view.
        return view('menu.jobs.internalNotes.create')
            ->with([
                'job' => $job,
                'priorities' => $priorities,
                'recipients' => $recipients
            ]);
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
        $selected_job = Job::find($request->job_id);
        // Create the new model instance.
        $new_internal_note = Note::create([
            'job_id' => $selected_job->id,
            'sender_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'priority_id' => $request->priority_id ?? 4, // Low.
            'text' => $request->text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => 1, // Is Internal.
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'recipient_seen_at' => $request->recipient_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'recipient_acknowledged_at' => $request->recipient_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
        ]);
        // Send the email.
        // Check for a recipient.
        if ($new_internal_note->recipient_id != null && $new_internal_note->recipient_id != Auth::id()) {
            // Find the message recipient.
            $selected_user = User::find($new_internal_note->recipient_id);
            // Create the data array for the notification.
            $data = [
                'recipient_name' => $selected_user->getFullNameAttribute(),
                'job_id' => $selected_job->id
            ];
            // Create the new email.
            Mail::to($selected_user->email)
                ->send(new StaffNewNote($data));
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('jobs.show', $selected_job->id)
            ->with('success', 'You have successfully created a new note.');
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
        // Set The Required Variables.
        // All staff users.
        $all_staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->whereNotIn('id', [1,Auth::id()]) // Not the first user or the authenticated user.
            ->where('login_status_id', 1) // 1 = Is Active.
            ->with('account_role')
            ->get();
        // Return the show view.
        return view('menu.jobs.internalNotes.show')
            ->with([
                'selected_note' => $selected_note,
                'all_staff_members' => $all_staff_members,
            ]);
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
        $job_note = Note::findOrFail($id);
        // Set The Required Variables.
        $selected_job_id = $job_note->job_id;
        // Delete the selected model instance.
        $job_note->delete();
        // Return a redirect to the job show route.
        return redirect()
            ->route('jobs.show', $selected_job_id)
            ->with('success', 'You have successfully deleted the selected note.');
    }
}
