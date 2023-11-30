<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use Yajra\Datatables\Datatables;

class JobDatatableController extends Controller
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
        $jobs = Job::select('id', 'tenant_suburb', 'tenant_postcode', 'customer_id', 'job_status_id')
            ->with(['job_status' => function($q) {
                return $q->select(['id', 'title']);
            }])
            ->with(['customer' => function($q) {
                return $q->select(['id', 'first_name', 'last_name']);
            }])
            ->with('job_types')
            ->get();

        return Datatables::of($jobs)
            // Customer full name.
            ->editColumn('customer_id', function ($job) {
                // Customer full name.
                return $job->customer->getFullNameAttribute();
            })
            // Tenant suburb.
            ->addColumn('suburb', function ($job) {
                // Suburb.
                return $job->tenant_suburb;
            })
            // Tenant postcode.
            ->addColumn('postcode', function ($job) {
                // Suburb.
                return $job->tenant_postcode;
            })
            // Job status.
            ->editColumn('job_status_id', function ($job) {
                // Job status title.
                return $job->job_status->title;
            })
            // Job type.
            ->editColumn('job_type_id', function ($job) {
                // job type.
                if ($job->job_types->first()) {
                    // the job type field is set.
                    return '<span class="badge badge-dark py-2 px-2"><i class="fas fa-tools mr-2" aria-hidden="true"></i>'. $job->job_types->first()->title .'</span>';
                } else {
                    // The job type field is empty.
                    return '<span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>No job types have been specified</span>';
                }
            })
            // Actions.
            ->addColumn('action', function ($job) {
                // View button.
                return '<a href="'. route('jobs.show', $job->id).'" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            ->rawColumns(['job_type_id', 'action'])
            ->make(true);
    }
}
