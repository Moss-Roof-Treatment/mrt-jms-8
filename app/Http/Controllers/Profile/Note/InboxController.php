<?php

namespace App\Http\Controllers\Profile\Note;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Quote;
use Auth;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class InboxController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return the index view.
        return view('profile.notes.inbox.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set the date of two months ago.
        $date = Carbon::today()->subMonths(2);

        // NEW NOTES
        // Unseen received notes.
        $new_notes = Note::where('created_at', '>=', $date)
            ->where('recipient_id', Auth::id())
            ->where('recipient_acknowledged_at', null)
            ->with('job')
            ->with('sender')
            ->get();

        // Construct the datatable.
        return Datatables::of($new_notes)
            // Job ID 
            ->editColumn('id', function ($new_note) { 
                // Check if the job_id is null.
                if ($new_note->job_id == null) {
                    // The job_type_id is null.
                    return '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // Set the Auth user id.
                    $user_id = Auth::id();
                    // Set the job id.
                    $job_id = $new_note->job_id;
                    // Find the first quote with the entered job id
                    $quotes = Quote::whereHas('job', function ($q) use ($job_id) {
                        return $q->where('job_id', $job_id);
                    })->whereHas('quote_users', function ($q) use ($user_id) {
                        return $q->where('tradesperson_id', $user_id);
                    })->get();
                    // Check the count of the found quotes to determine which result to display.
                    if ($quotes->count() == 0) {
                        // Check the account role of the authenticated user.
                        if (Auth::user()->account_role->id <= 2) { // staff or above.
                            // The user is a staff user.
                            // Return a link to view the job in the job menu of the main menu. 
                            return '<a href="' . route('jobs.show', $job_id) . '">' . $new_note->job_id . '</a>';
                        } else {
                            // The user is not a staff user.
                            // Return the id without a link.
                            return $new_note->job_id;
                        }
                    } elseif ($quotes->count() == 1) {
                        // Get the first / only result.
                        $quote_id = $quotes->first()->id;
                        // Return the link to view the html link.
                        return '<a href="' . route('profile-jobs.show', $quote_id) . '">' . $new_note->job_id . '</a>';
                    } elseif ($quotes->count() >= 2) {
                        // This will be the link to open a modal with the different quote ids on it as there is more than one.
                        // This will return a view with the actions for the modal.
                        // Return the id of the job without a link as the modal functionality has not been made yet.
                        return $new_note->job_id;
                    } else {
                        // Catch any edge case that has previously not be thought of.
                        // Return the id without a link.
                        return $new_note->job_id;
                    }
                }
            })
            // Add options button column.
            ->addColumn('suburb', function ($new_note) {
                // Check if the job id is not null.
                if ($new_note->job_id == null) {
                    return '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    return $new_note->job->tenant_suburb;
                }
            })
            // Sender ID field.
            ->editColumn('sender_id', function ($new_note) {
                // Check if the sender exists.
                if ($new_note->sender_id == null) {
                    // The sender id is null.
                    $sender = '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // The sender id exists.
                    $sender = $new_note->sender->getFullNameAttribute();
                }
                // Return the sender variable.
                return $sender;
            })
            ->editColumn('created_at', function ($new_note) {
                return $new_note->created_at->format('d/m/y - h:iA');
            })
            ->editColumn('text', function ($new_note) {
                // Shorten note text.
                $text = substr($new_note->text, 0, 500);
                // Add ellipsis if the text exceeds the specified length count.
                $text_ellipsis = strlen($new_note->text) > 500 ? '...' : '';
                // Check if the note has been read to see if bolding is required.
                if ($new_note->recipient_seen_at == null) {
                    // The note is unread.
                    // Return the text with bolding.
                    return '<b>' . $text . $text_ellipsis . '</b>';
                } else {
                    // The note is read.
                    // Return the text without bolding.
                    return $text . $text_ellipsis;
                }
            })
            ->addColumn('action', 'profile.notes.actions.actions')
            ->rawColumns(['id', 'suburb', 'sender_id', 'text', 'action'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find all of the required model instances.
        $selected_note = Note::findOrFail($id);
        // Validate permission.
        // Check if the auth user is the recipient or the sender.
        if ($selected_note->recipient_id != Auth::id() && $selected_note->sender_id != Auth::id()) {
            // The auth user is not the recipient or the sender.
            // Return a redirect back to the auth users notes index route.
            return redirect()
                ->route('profile-notes.index')
                ->with('danger', 'You do not have permission to view the selected note.');
        }
        // Update the selected model instance.
        // Check if the recipient id is the authenticated user and recipient seen at is null. 
        if ($selected_note->recipient_id == Auth::id() && $selected_note->recipient_seen_at == null) {
            // Set the note to seen.
            $selected_note->update([
                'recipient_seen_at' => Carbon::now()
            ]);
        }
        // Return the show view.
        return view('profile.notes.inbox.show')
            ->with('selected_note', $selected_note);
    }
}
