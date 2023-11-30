<?php

namespace App\Http\Controllers\Profile\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\JobStatus;
use App\Models\Quote;
use Auth;

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
        $this->middleware('isAnyStaffMember');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Set The Required Variables.
        // Selected job statuses.
        $selected_job_statuses = JobStatus::whereIn('id', [5,6,7,8,9]) // 5 = Start (Deposit Paid), 6 = Start (Payment on Completion), 7 = Completed, 8 = invoiced, 9 = Paid.
            ->select('color', 'title')
            ->get();
        // Return the index view.
        return view('profile.calendar.index')
            ->with('selected_job_statuses', $selected_job_statuses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // All user hosted events.
        $all_user_hosted_events = Event::where('staff_id', Auth::id());
        // All user tradesperson events.
        $all_tradespersons_quote_job_ids = Quote::whereRelation('quote_users', 'tradesperson_id', Auth::id())
            ->where('finalised_date', '!=', null)
            ->pluck('job_id');
        // Check if the ids array is empty.
        if ($all_tradespersons_quote_job_ids->isEmpty()) {
            // Find events from the id array and union them with the personal events.
            $events = Event::where('staff_id', Auth::id())->get();
        } else {
            // Find events from the id array and union them with the personal events.
            $events = Event::whereIn('job_id', $all_tradespersons_quote_job_ids)
                ->union($all_user_hosted_events)
                ->get();
        }
        // Return a Json response with the selected events.
        return response()->json($events);
    }
}
