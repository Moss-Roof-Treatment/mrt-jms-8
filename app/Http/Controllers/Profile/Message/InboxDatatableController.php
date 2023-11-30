<?php

namespace App\Http\Controllers\Profile\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Auth;
use Yajra\Datatables\Datatables;

class InboxDatatableController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // NEW MESSAGES
        // New messages sent to the auth user.
        $new_messages = Message::where('recipient_id', Auth::id())
            ->where('recipient_seen_at', null)
            ->get();

        // Construct the datatable.
        return Datatables::of($new_messages)
            // Edit the sender id field.
            ->editColumn('sender_id', function ($message) {
                // Check if the message does not have any responses.
                if (!$message->replies()->exists()) {
                    // The message has no responses, show the sender id.
                    return $message->sender->getFullNameAttribute();
                } else {
                    // The message has responses.
                    // return the reply icon and the sender of the last message response.
                    return '<i class="fas fa-reply mr-2" aria-hidden="true"></i>' . $message->replies()->latest()->first()->sender->getFullNameAttribute();
                }
            })
            // Edit the text field.
            ->editColumn('text', function ($message) {
                // Check if the message does not have any responses.
                if (!$message->replies()->exists()) {
                    // The message has no responses, show the message text.
                    // Shorten message text.
                    $text = substr($message->text, 0, 80);
                    // Add ellipsis if the text exceeds the specified length count.
                    $text_ellipsis = strlen($message->text) > 80 ? '...' : '';
                    // Return the text.
                    return $text . $text_ellipsis;
                } else {
                    // The message has responses.
                    // Shorten message text.
                    $text = substr($message->replies()->latest()->first()->text, 0, 80);
                    // Add ellipsis if the text exceeds the specified length count.
                    $text_ellipsis = strlen($message->replies()->latest()->first()->text) > 80 ? '...' : '';
                    // Response count.
                    $count = ' (' . $message->replies->count() . ')';
                    // Return the text.
                    return $text . $text_ellipsis . $count;
                }
            })
            // Edit the created at field.
            ->editColumn('created_at', function ($message) {
                // Check if the message does not have any responses.
                if (!$message->replies()->exists()) {
                    // The message has no responses, show the created_at id.
                    return date('d/m/y - h:iA', strtotime($message->created_at));
                } else {
                    // The message has responses.
                    // return the reply icon and the created_at of the last message response.
                    return date('d/m/y - h:iA', strtotime($message->replies()->latest()->first()->created_at));
                }
            })
            // Add options button column.
            ->addColumn('action', 'profile.messages.actions.actions')
            ->rawColumns(['sender_id', 'action'])
            ->make(true);
    }
}
