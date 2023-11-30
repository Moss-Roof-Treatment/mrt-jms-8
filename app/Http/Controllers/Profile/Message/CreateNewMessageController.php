<?php

namespace App\Http\Controllers\Profile\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Priority;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class CreateNewMessageController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
}
