<?php

namespace App\Http\Controllers\Menu\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use Carbon\Carbon;

class JobStatisticsController extends Controller
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
        // Total jobs.
        $total_jobs = Job::count();
        // Unsold jobs.
        $unsold_jobs_count = Job::whereIn('job_status_id', [1,2,3,10,11]) // quote request, new, pending, not given, not quoted.
            ->count();
        // Sold jobs.
        $sold_jobs_count = Job::whereIn('job_status_id', [4,5,6,7,8,9]) // not quote request, new, pending.
            ->count();
        // Return the index view.
        return view('menu.reports.jobStatistics.index')
            ->with([
                'total_jobs' => $total_jobs,
                'sold_jobs_count' => $sold_jobs_count,
                'unsold_jobs_count' => $unsold_jobs_count
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Validate The Request Data.

        // Check for inputs.
        if ($request->start_date == null && $request->end_date == null) {
            // If no input is present, redirect back with error message.
            return back()
                ->with('warning', 'Please select at least one of the available options to filter the selected report.');
        }

        // Set The Required Variables.

        // Set the start date.
        $start_date = Carbon::parse($request->start_date);
        // Set the end date.
        $end_date = isset($request->end_date)
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::parse($request->start_date)->endOfDay();

        // VALIDATE START AND END DATE
        // Check that start date is before end date. 
        if ($start_date->greaterThan($end_date)) {
            // Return redirect as start date is after the end date.
            return redirect()
                ->route('job-statistics-report.index')
                ->with('warning', 'Please select a starting date that is before the end date to filter the selected report.');
        }

        // Total jobs.
        $total_jobs_count = Job::whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Unsold jobs.
        $unsold_jobs_count = Job::whereIn('job_status_id', [1,2,3,10,11]) // quote request, new, pending.
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Sold jobs.
        $sold_jobs_count = Job::whereIn('job_status_id', [4,5,6,7,8,9]) // not quote request, new, pending.
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Return the index view.
        return view('menu.reports.jobStatistics.results')
            ->with([
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_jobs_count' => $total_jobs_count,
                'sold_jobs_count' => $sold_jobs_count,
                'unsold_jobs_count' => $unsold_jobs_count
            ]);
    }
}
