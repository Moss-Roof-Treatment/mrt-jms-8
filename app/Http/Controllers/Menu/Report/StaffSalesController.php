<?php

namespace App\Http\Controllers\Menu\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use Carbon\Carbon;

class StaffSalesController extends Controller
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

        // SOLD JOBS BY SALES PERSON
        $sold_jobs_by_salesperson = Job::has('salesperson')
            ->whereIn('job_status_id', [4,5,6,7,8,9]) // Not quote request, new, pending.
            ->with('salesperson:id,first_name,last_name')
            ->get();

        // Group the jobs by salesperson_id and sort by descending count.
        $sold_salesperson_jobs = $sold_jobs_by_salesperson->groupBy('salesperson_id')->sortByDesc(function($sold_salesperson)
        {
            // Count of each group of salespersons.
            return $sold_salesperson->count();
        });

        // Total count of jobs with a salesperson so the figures are not calculated against the jobs count.
        $total_sold_salesperson_jobs = $sold_jobs_by_salesperson->count();

        // SOLD JOBS BY SALES PERSON
        $unsold_jobs_by_salesperson = Job::has('salesperson')
            ->whereIn('job_status_id', [1,2,3,10,11]) // quote request, new, pending.
            ->get();

        // Group the jobs by salesperson_id and sort by descending count.
        $unsold_salesperson_jobs = $unsold_jobs_by_salesperson->groupBy('salesperson_id')->sortByDesc(function($unsold_salesperson)
        {
            // Count of each group of salespersons.
            return $unsold_salesperson->count();
        });

        // Total count of jobs with a salesperson so the figures are not calculated against the jobs count.
        $total_unsold_salesperson_jobs = $unsold_jobs_by_salesperson->count();

        // Return the index view.
        return view('menu.reports.staffSales.index')
            ->with([
                'sold_salesperson_jobs' => $sold_salesperson_jobs,
                'total_sold_salesperson_jobs' => $total_sold_salesperson_jobs,
                'unsold_salesperson_jobs' => $unsold_salesperson_jobs,
                'total_unsold_salesperson_jobs' => $total_unsold_salesperson_jobs
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
                ->route('staff-sales-statistics-report.index')
                ->with('warning', 'Please select a starting date that is before the end date to filter the selected report.');
        }

        // SOLD JOBS BY SALES PERSON
        $sold_jobs_by_salesperson = Job::has('salesperson')
            ->whereIn('job_status_id', [4,5,6,7,8,9]) // Not quote request, new, pending.
            ->with('salesperson:id,first_name,last_name')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();
    
        // Group the jobs by salesperson_id and sort by descending count.
        $sold_salesperson_jobs = $sold_jobs_by_salesperson->groupBy('salesperson_id')->sortByDesc(function($sold_salesperson)
        {
            // Count of each group of salespersons.
            return $sold_salesperson->count();
        });

        // Total count of jobs with a salesperson so the figures are not calculated against the jobs count.
        $total_sold_salesperson_jobs = $sold_jobs_by_salesperson->count();

        // SOLD JOBS BY SALES PERSON
        $unsold_jobs_by_salesperson = Job::has('salesperson')
            ->whereIn('job_status_id', [1,2,3,10,11]) // quote request, new, pending.
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        // Group the jobs by salesperson_id and sort by descending count.
        $unsold_salesperson_jobs = $unsold_jobs_by_salesperson->groupBy('salesperson_id')->sortByDesc(function($unsold_salesperson)
        {
            // Count of each group of salespersons.
            return $unsold_salesperson->count();
        });

        // Total count of jobs with a salesperson so the figures are not calculated against the jobs count.
        $total_unsold_salesperson_jobs = $unsold_jobs_by_salesperson->count();

        // Return the index view.
        return view('menu.reports.staffSales.results')
            ->with([
                'start_date' => $start_date,
                'end_date' => $end_date,
                'sold_salesperson_jobs' => $sold_salesperson_jobs,
                'total_sold_salesperson_jobs' => $total_sold_salesperson_jobs,
                'unsold_salesperson_jobs' => $unsold_salesperson_jobs,
                'total_unsold_salesperson_jobs' => $total_unsold_salesperson_jobs
            ]);
    }
}