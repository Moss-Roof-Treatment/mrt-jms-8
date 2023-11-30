<?php

namespace App\Http\Controllers\Menu\Job\Filtered;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobStatus;

class FilterController extends Controller
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
    public function index(Request $request)
    {
        // All job statuses sorted by id.
        $all_job_statuses = JobStatus::all('id', 'title')
            ->sortBy('id');
        // Selected option.
        $selected_option = $request->job_status_id;
        // Put selected job status id into session.
        session(['filtered_job_status_id' => $selected_option]);
        // Filter which view is required.
        if ($selected_option == 7) { // Completed.
            // Completed view.
            return view('menu.jobs.filtered.completed.index')->with([
                'all_job_statuses' => $all_job_statuses,
                'selected_option' => $selected_option
                ]);
        } elseif ($selected_option == 3) { // Pending.
            // Pending view.
            return view('menu.jobs.filtered.pending.index')->with([
                'all_job_statuses' => $all_job_statuses,
                'selected_option' => $selected_option
                ]);
        } elseif ($selected_option == 4 || $selected_option == 5 || $selected_option == 6) { // Sold (Deposit Pending), Sold (Deposit Paid), Sold (Payment On Completion).
            // Sold view.
            return view('menu.jobs.filtered.sold.index')->with([
                'all_job_statuses' => $all_job_statuses,
                'selected_option' => $selected_option
                ]);
        } else { // All others.
            // Default view.
            return view('menu.jobs.filtered.default.index')->with([ 
                'all_job_statuses' => $all_job_statuses,
                'selected_option' => $selected_option
                ]);
        }
    }
}
