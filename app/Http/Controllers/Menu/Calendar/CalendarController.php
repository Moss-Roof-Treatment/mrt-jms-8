<?php

namespace App\Http\Controllers\Menu\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\JobStatus;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class CalendarController extends Controller
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
        // Set The Required Variables.
        // All staff users.
        $staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('id', '!=', 1) // Not the first user in the database.
            ->where('login_status_id', 1) // 1 = Is Active.
            ->with('account_role')
            ->get();
        // Unknown jobs.
        $unknown_jobs = Event::whereHas('job', function ($q) {
            return $q->whereIn('job_status_id', [4,5,6]) // 4 = Deposit Pending, 5 = Deposit Paid, 6 = Deposit Pay on Completion.
                ->where('start_date', null);
        })->with('job.job_status')
            ->get();
        // All job statuses.
        $all_job_statuses = JobStatus::all('calendar_title', 'color');
        // Return the index view.
        return view('menu.calendar.index')
            ->with([
                'all_job_statuses' => $all_job_statuses,
                'staff_members' => $staff_members,
                'unknown_jobs' => $unknown_jobs
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // All staff users.
        $staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('id', '!=', 1) // Not the first user in the database.
            ->with('account_role')
            ->get();
        // Return the create view.
        return view('menu.calendar.create')
            ->with('staff_members', $staff_members);
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
            'staff_id' => 'required',
            'title' => 'required|string|min:3|max:80',
            'description' => 'sometimes|nullable|string|min:10|max:1000',
            'start' => 'required|string',
            'end' => 'required|string',
        ]);
        // Set The Required Variables.
        // Find the required user.
        $selected_user = User::find($request->staff_id);
        // FORMAT HEX COLOUR.
        // Set the RGB Values.
        $r = hexdec(substr($selected_user->user_color, 1, 2));
        $g = hexdec(substr($selected_user->user_color, 3, 2));
        $b = hexdec(substr($selected_user->user_color, 5, 2));
        // Calculate YIQ colour space.
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        // Set the text colour based on the calculated value.
        if ($yiq >= 128) {
            $text_color = '#000000'; // Black
        } else {
            $text_color = '#ffffff'; // White
        }
        // Create the new model instance.
        Event::create([
            'user_id' => Auth::id(),
            'title' => ucwords($request->title),
            'description' => ucfirst($request->description),
            'staff_id' => $selected_user->id,
            'is_personal' => 1, // Is Personal.
            'start' => Carbon::parse($request->start), // Carbon parsed start date.
            'end' => Carbon::parse($request->end), // Carbon parsed end date.
            'color' => $selected_user->user_color,
            'textColor' => $text_color,
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('calendar.index')
            ->with('success', 'You have successfully created a new calendar event.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Set The Required Variables.
        $selected_event = Event::with('notes')->findOrFail($id);
        // Return the show view.
        return view('menu.calendar.show')
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
        // Set The Required Variables.
        // Find the required model instance.
        $event = Event::findOrFail($id);
        // All staff users.
        $staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('id', '!=', 1) // Not the first user in the database.
            ->with('account_role')
            ->get();
        // Return the edit view.
        return view('menu.calendar.edit')
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
        // Find the required model instance.
        $event = Event::findOrFail($id);
        // Set the event colour.
        $event_color = $request->color;
        // FORMAT HEX COLOUR.
        // Set the RGB Values.
        $r = hexdec(substr($event_color, 1, 2));
        $g = hexdec(substr($event_color, 3, 2));
        $b = hexdec(substr($event_color, 5, 2));
        // Calculate YIQ colour space.
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        // Set the text colour based on the calculated value.
        if ($yiq >= 128) {
            $text_color = '#000000'; // Black
        } else {
            $text_color = '#ffffff'; // White
        }
        // Update the selected model instance.
        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'staff_id' => $request->staff_id,
            'start' => Carbon::parse($request->start), // Carbon parsed start date.
            'end' => Carbon::parse($request->end), // Carbon parsed end date.
            'color' => $event_color,
            'textColor' => $text_color
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('calendar.show', $id)
            ->with('success', 'You have successfully edited the selected calendar event.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Set The Required Variables.
        $selected_event = Event::findOrFail($id);
        //  Delete selected model instance.
        $selected_event->delete();
        // Return the index route.
        return redirect()
            ->route('calendar.index')
            ->with('success', 'You have successfully deleted the selected calendar event');
    }
}
