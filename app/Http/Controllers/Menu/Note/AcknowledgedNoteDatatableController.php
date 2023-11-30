<?php

namespace App\Http\Controllers\Menu\Note;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Yajra\Datatables\Datatables;

class AcknowledgedNoteDatatableController extends Controller
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
        // // All acknowledged notes.
        $unread_notes = Note::where('recipient_id', '!=', null)
            ->where('recipient_seen_at', null)
            ->select('id', 'job_id', 'sender_id', 'recipient_id', 'created_at', 'text', 'jms_acknowledged_at');

        return Datatables::of($unread_notes)
            // Job ID 
            ->editColumn('job_id', function ($unread_note) {
                // Check if the job_id is not null.
                if ($unread_note->job_id != null) {
                    // return a link to view the job if it exists.
                    return "<a href='" . route('jobs.show', $unread_note->job_id) . "'>" . $unread_note->job_id . "</a>";
                }
            })
            // Sender ID field.
            ->editColumn('recipient_id', function ($unread_note) {
                // Check if the sender exists.
                if ($unread_note->recipient_id == null) {
                    // The sender id is null.
                    $sender = '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // The sender id exists.
                    $sender = $unread_note->recipient->getFullNameAttribute();
                }
                // Return the sender variable.
                return $sender;
            })
            ->editColumn('created_at', function ($unread_note) {
                return $unread_note->created_at->format('d/m/y - h:iA');
            })
            ->editColumn('text', function ($unread_note) {
                // Shorten note text.
                $text = substr($unread_note->text, 0, 500);
                // Add ellipsis if the text exceeds the specified length count.
                $text_ellipsis = strlen($unread_note->text) > 500 ? '...' : '';
                // Return the note text.
                return '<b>' . $text . $text_ellipsis . '</b>';
            })
            // Add options button column.
            ->addColumn('action', 'menu.notes.actions.acknowledgeNoteActions')
            // Set class for the table row.
            ->setRowClass(function ($unread_note) {
                // Check if the sender exists.
                if ($unread_note->recipient_id == null) {
                    // The sender id is null.
                    $class = '';
                } else {
                    // The sender exists.
                    // Set row colour based on account role.
                    switch ($unread_note->recipient->account_role_id) {
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
        ->rawColumns(['job_id', 'recipient_id', 'text', 'action'])
        ->make(true);
    }
}
