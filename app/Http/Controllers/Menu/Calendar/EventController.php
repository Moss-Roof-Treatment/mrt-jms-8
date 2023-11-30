<?php

namespace App\Http\Controllers\Menu\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

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
        $this->middleware('isStaff');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Find all the required model instances.

        // Unknown jobs.
        $unknown_jobs = Event::whereHas('job', function ($q) {
            return $q->whereIn('job_status_id', [4,5,6]) // 4 = Deposit Pending, 5 = Deposit Paid, 6 = Deposit Pay on Completion.
                ->where('start_date', null);
        })->pluck('id')->toArray();

        // Find all events and order them by descending id.
        $events = Event::where('start', '!=', null)
            ->whereNotIn('id', $unknown_jobs)
            ->orderBy('id','DESC')
            ->get();

        // Return the JSON response.
        return response()->json($events);
    }
}
