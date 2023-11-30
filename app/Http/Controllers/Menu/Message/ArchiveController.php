<?php

namespace App\Http\Controllers\Menu\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\MessageReply;

class ArchiveController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Find all of the required model instances.
        $seen_messages = Message::where('jms_seen_at', '!=', null)
            ->with('sender')
            ->with('recipient')
            ->get();
        // Return the index view.
        return view('menu.messages.seen.index')
            ->with('seen_messages', $seen_messages);
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
        $selected_seen_message = Message::findOrFail($id);
        // Set The Required Variables.
        $message_replies = MessageReply::where('message_id', $id)
            ->where('is_visible', 1)
            ->get();
        // Return the show view.
        return view('menu.messages.seen.show')
            ->with([
                'selected_seen_message' => $selected_seen_message,
                'message_replies' => $message_replies
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
        $selected_seen_message = Message::findOrFail($id);
        // Delete the selected model instance.
        $selected_seen_message->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('messages-archive.index')
            ->with('success', 'You have successfully trashed the selected seen message');
    }
}
