<?php

namespace App\Http\Controllers\Profile\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\MessageReply;
use Auth;

class ResponseController extends Controller
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
        // Set The Required Variables.
        $selected_message = Message::find($request->message_id);
        // Create the new model instance.
        $message_reply = MessageReply::create([
            'message_id' => $selected_message->id,
            'sender_id' => Auth::id(),
            'text' => $request->text
        ]);
        // If the reply is send by the sender of the message.
        if ($message_reply->sender_id == $selected_message->sender_id) {
            // Let the sender know there is a new reply.
            $selected_message->update([
                'recipient_seen_at' => null
            ]);
        }
        // If the reply is send by the recipient of the message.
        if ($message_reply->sender_id == $selected_message->recipient_id) {
            // Let the recipient know there is a new reply.
            $selected_message->update([
                'sender_seen_at' => null
            ]);
        }
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfuly replied to the selected message.');
    }
}
