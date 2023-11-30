<?php

namespace App\Http\Controllers\Menu\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\MessageReply;
use App\Models\MessageAttachment;
use App\Models\Priority;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class MessageController extends Controller
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
        $new_messages = Message::where('jms_seen_at', null)
            ->with('sender')
            ->with('recipient')
            ->get();
        // Return the index view.
        return view('menu.messages.index')
            ->with('new_messages', $new_messages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Get all note priorities.
        $priorities = Priority::all('id', 'title');
        // Get all staff users.
        $staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->whereNotIn('id', [1,Auth::id()]) // Not the first user or the authenticated user.
            ->where('login_status_id', 1) // 1 = Is Active.
            ->with('account_role')
            ->get();
        // Return the create view.
        return view('menu.messages.create')
            ->with([
                'priorities' => $priorities,
                'staff_members' => $staff_members
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
            'recipients' => 'required',
            'text' => 'required|string|min:10|max:500',
        ]);

        // Create the new model instance.
        // Loop through each selected recipient.
        foreach($request->recipients as $recipient_id) {
            // Find the message recipient.
            $selected_user = User::find($recipient_id);
            // Create the new message.
            $new_message = Message::create([
                'sender_id' => Auth::id(),
                'recipient_id' => $selected_user->id,
                'priority_id' => $request->priority ?? 4, // Low.
                'text' => $request->text
            ]);
            // Check if the file exists in the request data.
            if ($request->hasFile('documents')) {
                // Loop through each uploaded document.
                foreach($request->file('documents') as $document){
                    // Set the filename - use pathinfo to remove the extention from the original name.
                    $filename = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $document->extension();
                    // Store document.
                    $document->storeAs('public/documents/messages', $filename);
                    // Create the attachment model instance.
                    MessageAttachment::create([
                        'message_id' => $new_message->id,
                        'title' => $filename,
                        'storage_path' => 'storage/documents/messages/' . $filename
                    ]);
                }
            }
        }
        // Return the index route.
        return redirect()
            ->route('messages.index')
            ->with('success', 'You have successfully sent your new message to the selected recipients.');
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
        $selected_message = Message::findOrFail($id);
        // Update the selected model instance.
        $selected_message->jms_seen_at = Carbon::now();
        $selected_message->save();
        // Set The Required Variables.
        $message_replies = MessageReply::where('message_id', $id)
            ->where('is_visible', 1)
            ->get();
        // Return the show view.
        return view('menu.messages.show')
            ->with([
                'selected_message' => $selected_message,
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
        $selected_message = Message::findOrFail($id);
        // Delete selected model instance.
        $selected_message->delete();
        // Return the index route.
        return redirect()
            ->route('messages.index')
            ->with('success', 'You have successfully trashed the selected seen message');
    }
}
