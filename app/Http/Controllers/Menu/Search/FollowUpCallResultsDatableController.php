<?php

namespace App\Http\Controllers\Menu\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobImage;
use App\Models\Quote;
use Yajra\Datatables\Datatables;

class FollowUpCallResultsDatableController extends Controller
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
        // Get the required model instances.
        $quotes = Quote::where('quote_status_id', session('filtered_quote_status_id'))
            ->select('id', 'customer_id', 'job_id', 'quote_status_id', 'quote_identifier', 'job_type_id')
            ->with(['customer' => fn ($q) => $q->select('id', 'first_name', 'last_name', 'email')])
            ->with('customer.user_logins')
            ->with(['job' => fn ($q) => $q->select('id', 'tenant_street_address', 'tenant_suburb', 'tenant_postcode', 'quote_sent_status_id', 'follow_up_call_status_id')])
            ->with(['job_type' => fn ($q) => $q->select('id','title')])
            ->with(['quote_status' => fn ($q) => $q->select('id','title')])
            ->with(['job.follow_up_call_status' => fn ($q) => $q->select('id','title', 'colour_id')])
            ->with('job.follow_up_call_status.colour')
            ->with(['customer.referral' => fn ($q) => $q->select('id','title')])
            ->get();
        // Generate the Datatable.
        return Datatables::of($quotes)
            // Customer full name.
            ->editColumn('customer_id', function ($quote) {
                // Return the customer full name.
                return $quote->customer->getFullNameAttribute();
            })
            // Tenant street address.
            ->addColumn('street_address', function ($quote) {
                // Return the tenant street address.
                return $quote->job->tenant_street_address;
            })
            // Tenant suburb.
            ->addColumn('suburb', function ($quote) {
                // Return the tenant suburb.
                return $quote->job->tenant_suburb;
            })
            // Tenant postcode.
            ->addColumn('postcode', function ($quote) {
                // Return the tenant postcode.
                return $quote->job->tenant_postcode;
            })
            // Customer referral title.
            ->addColumn('referral', function ($quote) {
                // Return the customer referral title.
                return $quote->customer->referral->title;
            })
            // Customer last login datetime.
            ->addColumn('last_login_date', function ($quote) {
                // Check if there is no email address and quote sent status of posted or 
                if ($quote->customer->email == null && $quote->job->quote_sent_status_id == 2 || $quote->job->quote_sent_status_id == 2) { // Posted
                    // Return message next.
                    return '<i class="fas fa-circle text-info mr-2" aria-hidden="true"></i>Posted';
                } else {
                    // Return the customer last login datetime.
                    return $quote->customer->getLastLoginAttribute();
                }
            })
            // Customer login count.
            ->addColumn('login_count', function ($job) {
                // Return the customer last login.
                return $job->customer->user_logins->count();
            })
            // Quote status.
            ->editColumn('quote_status_id', function ($quote) {
                // return the quote status title.
                return $quote->quote_status->title;
            })
            // Follow up call status.
            ->addColumn('follow_up_call_status', function ($quote) {
                // set the colour.
                $colour = '<i class="fas fa-square-full border border-dark" style="color:' . $quote->job->follow_up_call_status->colour->colour . ';"></i>';
                // Return the job follow up call status.
                return $colour . ' ' . $quote->job->follow_up_call_status->title;
            })
            // Job type.
            ->editColumn('job_type_id', function ($quote) {
                // Check if the job type status exists.
                if ($quote->job_type_id == null) {
                    // Return the not applicable badge.
                    return '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // Return the quote job type title.
                    return $quote->job_type->title;
                }
            })
            // Roof outline image.
            ->addColumn('image', function ($quote) {
                // Return the roof outline image.
                return '<img src="' . asset($quote->job->getFirstRoofOutlineImagePath()) . '" style="max-width:150px;" alt="">';
            })
            // Add options button column.
            ->addColumn('action', 'menu.search.followUpCalls.actions.actions')
            ->rawColumns(['last_login_date', 'login_count', 'job_type_id', 'follow_up_call_status', 'image', 'action'])
            ->make(true);
    }
}
