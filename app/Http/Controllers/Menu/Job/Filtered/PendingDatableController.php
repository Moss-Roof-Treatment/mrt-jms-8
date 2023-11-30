<?php

namespace App\Http\Controllers\Menu\Job\Filtered;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use Yajra\Datatables\Datatables;

class PendingDatableController extends Controller
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
        // All jobs with the required job status ids.
        $jobs = Job::where('job_status_id', session('filtered_job_status_id'))
            ->with('customer')
            ->with('customer.user_logins')
            ->with('job_types')
            ->get();

        return Datatables::of($jobs)
            // Start Date Field.
            ->editColumn('inspection_date', function ($job) {
                // Formatted start date.
                return $job->getFormattedInspectionDate();
            })
            // Count of use field.
            ->editColumn('customer_id', function ($job) {
                // Customer full name.
                return $job->customer->getFullNameAttribute();
            })
            // Email.
            ->addColumn('email', function ($job) {
                return $job->customer->email
                    ?? '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
            })
            // Count of use field.
            ->editColumn('job_type_id', function ($job) {
                // job type.
                if ($job->job_types()->exists()) {
                    // the job type field is set.
                    return '<span class="badge badge-dark py-2 px-2"><i class="fas fa-tools mr-2" aria-hidden="true"></i>'. $job->job_types->first()->title .'</span>';
                } else {
                    // The job type field is empty.
                    return '<span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>No job types have been specified</span>';
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
            ->rawColumns(['inspection_date', 'job_type_id', 'email', 'last_login_date', 'login_count', 'action',])
            ->make(true);
    }
}
