<?php

namespace App\Http\Controllers\Menu\Note;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Yajra\Datatables\Datatables;

class PendingNoteDatatableController extends Controller
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
        // All read notes.
        $seen_notes = Note::where('jms_seen_at', '!=', null)
            ->where('jms_acknowledged_at', null)
            ->with(['sender' => function($q) {
                return $q->select(['id', 'first_name', 'last_name', 'account_role_id']);
            }])
            ->select('id', 'job_id', 'sender_id', 'created_at', 'text', 'jms_acknowledged_at', 'recipient_seen_at', 'recipient_id');

        return Datatables::of($seen_notes)
            // Job ID 
            ->editColumn('job_id', function ($seen_notes) {
                // Check if the job_id is not null.
                if ($seen_notes->job_id != null) {
                    // return a link to view the job if it exists.
                    return "<a href='" . route('jobs.show', $seen_notes->job_id) . "'>" . $seen_notes->job_id . "</a>";
                }
            })  
            // Sender ID field.
            ->editColumn('sender_id', function ($seen_note) {
                // Check if the sender exists.
                if ($seen_note->sender_id == null) {
                    // The sender id is null.
                    $sender = '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // The sender id exists.
                    $sender = $seen_note->sender->getFullNameAttribute();
                }
                // Return the sender variable.
                return $sender;
            })
            ->editColumn('created_at', function ($seen_note) {
                return $seen_note->created_at->format('d/m/y - h:iA');
            })
            ->editColumn('text', function ($seen_note) {
                // Shorten note text.
                $text = substr($seen_note->text, 0, 500);
                // Add ellipsis if the text exceeds the specified length count.
                $text_ellipsis = strlen($seen_note->text) > 500 ? '...' : '';
                // Check if the note has been read by the recipient.
                if ($seen_note->recipient_seen_at == null && $seen_note->recipient_id != null) {
                    // The note is unread so bold the text.
                    return '<b>' . $text . $text_ellipsis . '</b>';
                } else {
                    // The note is read do not bold the text.
                    return $text . $text_ellipsis;
                }
            })
            // Add options button column.
            ->addColumn('action', 'menu.notes.actions.pendingNoteActions')
            // Set class for the table row.
            ->setRowClass(function ($seen_note) {
                // Check if the sender exists.
                if ($seen_note->sender_id == null) {
                    // The sender id is null.
                    $class = '';
                } else {
                    // The sender exists.
                    // Set row colour based on account role.
                    switch ($seen_note->sender->account_role_id) {
                        // Staff
                        case 2:
                            $class = 'table-secondary';
                            break;
                        // Tradesperson.
                        case 3:
                            $class = 'table-success';
                            break;
                        // Contractor.
                        case 4:
                            $class = 'table-success';
                            break;
                        // Customer.
                        case 5:
                            $class = 'table-primary';
                            break;
                        // Default - All other roles.
                        default:
                            $class = 'table-warning';
                    }
                }
                // Return the class variable to display the colour.
                return $class;
          })
          ->rawColumns(['job_id', 'sender_id', 'text', 'action'])
          ->make(true);
    }
}
