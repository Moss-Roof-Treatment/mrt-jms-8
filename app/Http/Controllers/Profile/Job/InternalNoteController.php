<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Priority;
use App\Models\User;
use App\Models\Quote;
use Auth;
use Carbon\Carbon;

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
        $this->middleware('isAnyStaffMember');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Find the quote in the session.
        $selected_quote = Quote::find($_GET['selected_quote_id']);
        // Get Priorities.
        $priorities = Priority::all('id', 'title');
        // All staff users.
        $recipients = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->whereNotIn('id', [1,Auth::id()]) // Not the first user or the authenticated user.
            ->with('account_role')
            ->get();
        // Return the create view.
        return view('profile.jobs.notes.internal.create')
            ->with([
                'selected_quote' => $selected_quote,
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
        $selected_quote = Quote::find($request->quote_id);
        // Create the new model instance.
        Note::create([
            'job_id' => $selected_quote->job_id,
            'sender_id' => Auth::id(),
            'text' => $request->text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'recipient_id' => $request->recipient_id,
            'is_internal' => 1, // Is internal.
            'priority_id' => $request->priority_id ?? 4, // Low.
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'recipient_seen_at' => $request->recipient_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'recipient_acknowledged_at' => $request->recipient_id == Auth::id() ? now() : null, // Mark as seen if the recipient is the same as the sender.
            'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
        ]);
        // Return a redirect to the job show route.
        return redirect()
            ->route('profile-jobs.show', $selected_quote->id)
            ->with('success', 'You have successfully created a new job note.');
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
        $job_note = Note::findOrFail($id);
        // Set The Required Variables.
        $selected_quote_id = $_GET['selected_quote_id'];
        // Return the show view.
        return view('profile.jobs.notes.internal.show')
            ->with([
                'job_note' => $job_note,
                'selected_quote_id' => $selected_quote_id
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
