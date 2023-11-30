<?php

namespace App\Http\Controllers\Menu\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Yajra\Datatables\Datatables;

class CalendarDatatableController extends Controller
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
        // Unknown jobs.
        $sold_job_event = Event::whereHas('job', function ($q) {
            return $q->whereIn('job_status_id', [4,5,6]) // 4 = Deposit Pending, 5 = Deposit Paid, 6 = Deposit Pay on Completion.
                ->where('start_date', null);
        })->with('job')
            ->with('job.job_status')
            ->with('job.customer')
            ->with('quote')
            ->with('quote.expected_payment_method')
            ->get();

        return Datatables::of($sold_job_event)
            // Event title.
            ->editColumn('title', function ($sold_job_event) {
                // Customer full name.
                return '<span class="icon" style="color:' . $sold_job_event->color . ';"><i class="fas fa-square-full mr-2 border border-dark"></i></span>' . $sold_job_event->title;
            })
            // Tenant postcode.
            ->addColumn('postcode', function ($sold_job_event) {
                // Suburb.
                return $sold_job_event->job->tenant_postcode;
            })
            // Customer full name.
            ->editColumn('customer_id', function ($sold_job_event) {
                // Customer full name.
                return $sold_job_event->job->customer->getFullNameAttribute();
            })
            // Job status.
            ->addColumn('job_status_id', function ($sold_job_event) {
                // Job status title.
                return $sold_job_event->job->job_status->title;
            })
            // Job status.
            ->addColumn('sold_date', function ($sold_job_event) {
                // Job status title.
                return $sold_job_event->job->getFormattedSoldDate();
            })
            // Job status.
            ->addColumn('expected_payment_method_id', function ($sold_job_event) {
                return $sold_job_event->quote->expected_payment_method->title ?? '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
            })
            // Actions.
            ->addColumn('action', function ($sold_job_event) {
                // View button.
                return '<a href="'. route('calendar.show', $sold_job_event->id).'" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            ->rawColumns(['title', 'job_status_id', 'sold_date', 'expected_payment_method_id', 'action'])
            ->make(true);
    }
}
