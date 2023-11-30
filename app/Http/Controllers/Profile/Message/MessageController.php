<?php

namespace App\Http\Controllers\Profile\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\MessageReply;
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
        return view('profile.messages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Get Note Priorities.
        $priorities = Priority::all('id', 'title');
        // All staff users.
        $recipients = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->whereNotIn('id', [1,Auth::id()]) // Not the first user or the authenticated user.
            ->with('account_role')
            ->get();
        // Return the create view.
        return view('profile.messages.create')
            ->with([
                'recipients' => $recipients,
                'priorities' => $priorities
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
            'recipient' => 'required',
            'text' => 'required|string|min:10|max:500',
        ]);
        // Create the new message.
        Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $request->recipient,
            'priority_id' => $request->priority,
            'text' => $request->text,
            'sender_seen_at' => Carbon::now()
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('profile-messages.index')
            ->with('success', 'You have successfully sent your new message to the selected recipient(s).');
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
        $selected_message = Message::findOrFail($id);
        // Validate permission.
        if ($selected_message->recipient_id != Auth::id() && $selected_message->sender_id != Auth::id()) {
            // Return a redirect back.
            return back()
                ->with('danger', 'You do not have permission to view the selected message as it does not belong to you.');
        }
        // Update the selected model instance.
        // If the auth user is viewing it as the recipient.
        if ($selected_message->recipient_id == Auth::id()) {
            $selected_message->update([
                'recipient_seen_at' => Carbon::now()
            ]);
        }
        // If the auth user is viewing it as the sender.
        if ($selected_message->sender_id == Auth::id()) {
            $selected_message->update([
                'sender_seen_at' => Carbon::now()
            ]);
        }
        // Set The Required Variables.
        $replies = MessageReply::where('message_id', $id)
            ->where('is_visible', 1)
            ->get();
        // Return the show view.
        return view('profile.messages.show')
            ->with([
                'selected_message' => $selected_message,
                'replies' => $replies
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the required model instance.
        $selected_message = Message::findOrFail($id);
        // Update the selected model instance.
        // If auth user is the sender.
        if ($selected_message->sender_id == Auth::id()) {
            $selected_message->update([
                'sender_seen_at' => Carbon::now()
            ]);
        }
        // If auth user is the recipient.
        if ($selected_message->recipient_id == Auth::id()) {
            $selected_message->update([
                'recipient_seen_at' => Carbon::now()
            ]);
        }
        // Return redirect to the index page.
        return redirect()
            ->route('profile-messages.index')
            ->with('success', 'You have successfully marked the selected message as read.');
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
        // Update the selected model instance.
        if ($selected_message->sender_id == Auth::id()) {
            $selected_message->update([
                'sender_is_visible' => 0
            ]);
        }
        if ($selected_message->recipient_id == Auth::id()) {
            $selected_message->update([
                'recipient_is_visible' => 0
            ]);
        }
        // Return redirect to the index page.
        return redirect()
            ->route('profile-messages.index')
            ->with('success', 'You have successfully deleted the selected ');
    }
}
