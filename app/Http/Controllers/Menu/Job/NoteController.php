<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Mail\Customer\NewJobNote;
use App\Models\Note;
use App\Models\Priority;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Find job.
        $job = Job::find($_GET['job_id']);
        // Get priorities.
        $priorities = Priority::all('id', 'title');
        // All staff users.
        $recipients = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->whereNotIn('id', [1,Auth::id()]) // Not the first user or the authenticated user.
            ->with('account_role')
            ->get();
        // Return the create view.
        return view('menu.jobs.notes.create')
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
        // Selected job.
        $selected_job = Job::find($request->job_id);
        // Create the new model instance.
        // Create new note.
        Note::create([
            'job_id' => $selected_job->id,
            'sender_id' => Auth::id(),
            'text' => $request->text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'priority_id' => $request->priority_id ?? 4, // Low.
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'recipient_id' => $selected_job->customer_id,
            'jms_seen_at' => Carbon::now(),
            'jms_acknowledged_at' => Carbon::now(),
        ]);
        // Send email.
        // Check if the notify customer by email checkbox is checked and the customer has an email address.
        if ($request->notify_customer_via_email != null && $selected_job->customer->email != null) {
            // Create the data array to populate the emails with.
            $data = [
                'recipient_name' => $selected_job->customer->getFullNameAttribute(),
                'job_id' => $selected_job->id
            ];
            // Send the email.
            Mail::to($selected_job->customer->email)
                ->send(new NewJobNote($data));
        }
        // Return a redirect to the job show route.
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
        return view('menu.jobs.notes.show')
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
        // Delete the selected model.
        $job_note->delete();
        // Return redirect to the job show page.
        return redirect()
            ->route('jobs.show', $selected_job_id)
            ->with('success', 'You have successfully deleted the selected job note.');
    }
}
