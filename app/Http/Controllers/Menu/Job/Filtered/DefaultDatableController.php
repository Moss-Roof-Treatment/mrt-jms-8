<?php

namespace App\Http\Controllers\Menu\Job\Filtered;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use Yajra\Datatables\Datatables;

class DefaultDatableController extends Controller
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
        $jobs = Job::where('job_status_id', session('filtered_job_status_id'))
            ->with('customer')
            ->with('customer.user_logins')
            ->with('job_status')
            ->with('job_types')
            ->get();

        return Datatables::of($jobs)
            // Count of use field.
            ->editColumn('customer_id', function ($job) {
                // Customer full name.
                return $job->customer->getFullNameAttribute();
            })
            // Count of use field.
            ->addColumn('suburb', function ($job) {
                // Suburb.
                return $job->tenant_suburb;
            })
            // Tenant postcode.
            ->addColumn('postcode', function ($job) {
                // Suburb.
                return $job->tenant_postcode;
            })
            // Count of use field.
            ->editColumn('job_status_id', function ($job) {
                // Job status title.
                return $job->job_status->title;
            })
            // Count of use field.
            ->editColumn('job_type_id', function ($job) {
                // Get the first job type.
                $value = $job->job_types()?->first();
                // Check if there is any job types specified.
                if ($value == null) {
                    // The job type field is empty.
                    return '<span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>No job types have been specified</span>';
                } else {
                    // the job type field is set.
                    return '<span class="badge badge-dark py-2 px-2"><i class="fas fa-tools mr-2" aria-hidden="true"></i>'. $job->job_types->first()->title .'</span>';
                }
            })
            // Customer last login datetime.
            ->addColumn('last_login_date', function ($job) {
                // Check if there is no email address and quote sent status of posted or 
                if ($job->customer->email == null && $job->quote_sent_status_id == 2 || $job->quote_sent_status_id == 2) { // Posted
                    // Return message next.
                    return '<i class="fas fa-circle text-info mr-2" aria-hidden="true"></i>Posted';
                } else {
                    // Return the customer last login datetime.
                    return $job->customer->getLastLoginAttribute();
                }
            })
            // Login count of the user.
            ->addColumn('login_count', function ($job) {
                return $job->customer->user_logins->count();
            })
            // Add options button column.
            ->addColumn('action', 'menu.jobs.actions.actions')
            ->rawColumns(['job_type_id', 'last_login_date', 'login_count', 'action'])
            ->make(true);
    }
}
