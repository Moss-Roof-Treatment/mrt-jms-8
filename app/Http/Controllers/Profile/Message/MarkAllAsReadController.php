<?php

namespace App\Http\Controllers\Profile\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Auth;
use Carbon\Carbon;

class MarkAllAsReadController extends Controller
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        // Set The Required Variables.
        // Get all unread messages where the authenticated user is the recipient. 
        $all_unread_recipient_messages = Message::where('recipient_id', Auth::id())
            ->where('recipient_seen_at', null);
        // Get all unread messages where the authenticated user is the sender.
        $all_unread_messages = Message::where('sender_id', Auth::id())
            ->where('sender_seen_at', null)
            ->union($all_unread_recipient_messages)
            ->get();
        // Secondary validation.
        // Check if there are any unread messages.
        if (!$all_unread_messages->count()) {
            // There are no messages to set as seen.
            // Return redirect back.
            return back()->with('warning', 'There are currently no messages to mark as read.');
        }
        // Update all model instances.
        // Loop through each unread message and set to seen.
        foreach($all_unread_messages as $selected_message) {
            // Check if the authenticated user is the recipient. 
            if ($selected_message->recipient_id == Auth::id()) {
                // Set the recipient seen at.
                $selected_message->update([
                    'recipient_seen_at' => Carbon::now() // is seen.
                ]);
            }
            // Check if the authenticated user is the sender. 
            if ($selected_message->sender_id == Auth::id()) {
                // Set the sender seen at.
                $selected_message->update([
                    'sender_seen_at' => Carbon::now() // is seen.
                ]);
            }
        }
        // Return redirect to the index view.
        return redirect()
            ->route('profile-messages.index')
            ->with('success', 'You have successfully marked all inbox messages as read.');
    }
}
