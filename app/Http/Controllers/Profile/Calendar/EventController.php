<?php

namespace App\Http\Controllers\Profile\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class EventController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('profile.calendar.events.create');
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
            'title' => 'required|string|min:3|max:80',
            'description' => 'sometimes|nullable|string|min:10|max:500',
            'color' => 'required|regex:/^#([A-Fa-f0-9]{6})$/',
            'start' => 'required|string',
            'end' => 'required|string',
        ]);
        // Set The Required Variables.
        // FORMAT HEX COLOUR.
        // Set the RGB Values.
        $r = hexdec(substr($request->color, 1, 2));
        $g = hexdec(substr($request->color, 3, 2));
        $b = hexdec(substr($request->color, 5, 2));
        // Calculate YIQ colour space.
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        // Set the text colour based on the calculated value.
        if ($yiq >= 128) {
            $event_text_colour = '#000000'; // Black
        } else {
            $event_text_colour = '#ffffff'; // White
        }
        // Create the new model instance.
        Event::create([
            'user_id' => Auth::id(),
            'title' => ucwords($request->title),
            'description' => ucfirst($request->description),
            'staff_id' => Auth::id(),
            'is_personal' => 1, //  0 = Not Personal, 1= Is Personal, Default is 0.
            'start' => Carbon::parse($request->start),
            'end' => Carbon::parse($request->end),
            'color' => $request->color,
            'textColor' => $event_text_colour
        ]);
        // Return the index view.
        return redirect()
            ->route('profile-calendar.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required event.
        $selected_event = Event::findOrFail($id);
        // Return the show view.
        return view('profile.calendar.events.show')
            ->with('selected_event', $selected_event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the required event.
        $event = Event::findOrFail($id);
        // All staff users.
        $staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('id', '!=', 1) // Not the first user in the database.
            ->with('account_role')
            ->get();
        // Return the edit view.
        return view('profile.calendar.events.edit')
            ->with([
                'event' => $event,
                'staff_members' => $staff_members
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
        // Validate The Request Data.
        $request->validate([
            'title' => 'required|string|min:3|max:80',
            'description' => 'sometimes|nullable|string|min:10|max:500',
            'color' => 'required|regex:/^#([A-Fa-f0-9]{6})$/',
            'start' => 'required|string',
            'end' => 'required|string',
        ]);
        // Set The Required Variables.
        // FORMAT HEX COLOUR.
        // Set the RGB Values.
        $r = hexdec(substr($request->color, 1, 2));
        $g = hexdec(substr($request->color, 3, 2));
        $b = hexdec(substr($request->color, 5, 2));
        // Calculate YIQ colour space.
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        // Set the text colour based on the calculated value.
        if ($yiq >= 128) {
            $event_text_colour = '#000000'; // Black
        } else {
            $event_text_colour = '#ffffff'; // White
        }
        // Find the required model instance.
        $event = Event::findOrFail($id);
        // Update the selected model instance.
        $event->update([
            'title' => ucwords($request->title),
            'description' => ucfirst($request->description),
            'start' => Carbon::parse($request->start),
            'end' => Carbon::parse($request->end),
            'color' => $request->color,
            'textColor' => $event_text_colour
        ]);
        // Return the show route.
        return redirect()
            ->route('profile-events.show', $id);
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
        $event = Event::findOrFail($id);
        // Delete the model instance relationships.
        $event->notes()->delete();
        // Delete selected model instance.
        $event->delete();
        // Return the index route.
        return redirect()
            ->route('profile-calendar.index');
    }
}
