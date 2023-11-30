<?php

namespace App\Http\Controllers\Profile\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Note;
use Auth;
use Carbon\Carbon;

class EventNoteController extends Controller
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
        // Create a log message.
        Log::info('404 - The selected user has navigated to the index route of a route resource that does not exist.');
        // Return abort 404.
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create the new model instance.
        $new_internal_note = Note::create([
            'sender_id' => Auth::id(),
            'event_id' => $request->event_id,
            'text' => $request->text . ' - ' . Auth::user()->getFullNameAttribute() . '.',
            'jms_seen_at' => Carbon::now(),
            'jms_acknowledged_at' => Carbon::now()
        ]);
        // Return a redirect to the profile events show route.
        return redirect()
            ->route('profile-events.show', $new_internal_note->event_id)
            ->with('success', 'You have successfully create a new note on the selected event.');
    }
}
