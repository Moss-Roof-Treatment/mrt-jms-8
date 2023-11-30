<?php

namespace App\Http\Controllers\Profile\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Auth;
use Yajra\Datatables\Datatables;

class PendingJobsDatatableController extends Controller
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
        // Get all of the pending events that require a real date set.
        $pending_events = Event::whereHas('quote.quote_users', fn ($q) => $q
            ->where('tradesperson_id', Auth::id())) // The authenticated user.
            ->whereHas('quote', fn ($q) => $q // Events that have a quote.
                ->where('finalised_date', '!=', null) // The finalised date has been set.
                ->where('completion_date', null) // Completion date has not been set.
            )
            ->whereHas('job', fn ($q) => $q // Events that have a job.
                ->whereIn('job_status_id', [5,6]) // 5 - Sold (Deposit Paid), 6 - Sold (Payment On Completion).
            )
            ->where('is_tradesperson_confirmed', 0) // The real work date has not been set.
            ->select('id', 'job_id', 'quote_id', 'color', 'title') // Only the selected values. 
            ->with(['job' => fn ($q) => $q->select('id', 'tenant_name','tenant_postcode', 'sold_date', 'job_status_id')]) // Only the selected values. 
            ->with(['quote' => fn ($q) => $q->select('id', 'expected_payment_method_id')]) // Only the selected values. 
            ->with(['quote.quote_status' => fn ($q) => $q->select('id', 'title')]) // Only the selected values. 
            ->with(['quote.expected_payment_method' => fn ($q) => $q->select('id', 'title')]) // Only the selected values. 
            ->with(['job.job_status' => fn ($q) => $q->select('id', 'title')]) // Only the selected values. 
            ->get();
        // Construct the datatable.
        return Datatables::of($pending_events)
            // Job ID 
            ->editColumn('id', function ($pending_event) { 
                // Check if the quote_id is null.
                $pending_event->quote_id == null
                // The quote_id is null, return the not applicable badge.
                ? $value = '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>'
                // Return a link to view the quote.
                : $value = '<span class="icon" style="color:' . $pending_event->color . ';"><i class="fas fa-square-full mr-2 border border-dark"></i></span>' . $pending_event->title;
                // Return the value.
                return $value;
            })
            // Add the tennant postcode column.
            ->addColumn('tenant_postcode', function ($pending_event) {
                return $pending_event->job->tenant_postcode;
            })
            // Add the tennant name column.
            ->addColumn('tenant_name', function ($pending_event) {
                // Return the sender variable.
                return $pending_event->job->tenant_name;
            })
            // Add the quote status column.
            ->addColumn('quote_status', function ($pending_event) {
                return $pending_event->job->job_status->title ?? null;
            })
            // Add the job sold date column.
            ->addColumn('sold_date', function ($pending_event) {
                // Check if the job sold date is null.
                $pending_event->job->sold_date == null
                // The sold date is null, return the not applicable badge.
                ? $value = '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>'
                // The sold date is not null, return the sold date.
                : $value = $pending_event->job->sold_date;
                // Return the value.
                return $value;
            })
            // Add the quote expected payment method column.
            ->addColumn('expected_payment_method', function ($pending_event) {
                // Check if the quote expected payment method is null.
                $pending_event->quote->expected_payment_method_id == null
                // The sold date is null, return the not applicable badge.
                ? $value = '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>'
                // The sold date is not null, return the sold date.
                : $value = $pending_event->quote->expected_payment_method->title;
                // Return the value.
                return $value;
            })
            // Add options button column.
            ->addColumn('action', function ($pending_event) {
                // Check if the quote_id is null.
                $pending_event->quote_id == null
                // The quote_id is null, return the not applicable badge.
                ? $value = '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>'
                // Return a button to view the quote.
                : $value = '<a href="' . route('profile-jobs.show', $pending_event->quote_id) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
                // Return the value.
                return $value;
            })
            ->rawColumns(['id', 'sold_date', 'action'])
            ->make(true);
    }
}
