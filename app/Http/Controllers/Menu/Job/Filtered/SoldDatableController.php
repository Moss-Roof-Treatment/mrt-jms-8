<?php

namespace App\Http\Controllers\Menu\Job\Filtered;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\QuoteUser;
use App\Models\Quote;
use App\Models\User;
use Yajra\Datatables\Datatables;

class SoldDatableController extends Controller
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
            ->with('job_status')
            ->with('job_types')
            ->get();

        return Datatables::of($jobs)
            // Start Date Field.
            ->editColumn('start_date', function ($job) {
                // Formatted start date.
                return $job->getFormattedStartDate();
            })
            // Count of use field.
            ->editColumn('customer_id', function ($job) {
                // Customer full name.
                return $job->customer->getFullNameAttribute();
            })
            // Count of use field.
            ->editColumn('job_status_id', function ($job) {
                // Job status title.
                return $job->job_status->title;
            })
            // Count of use field.
            ->editColumn('job_type_id', function ($job) {
                // job type.
                if ($job->has('job_types')) {
                    // the job type field is set.
                    return '<span class="badge badge-dark py-2 px-2"><i class="fas fa-tools mr-2" aria-hidden="true"></i>'. $job->job_types->first()->title .'</span>';
                } else {
                    // The job type field is empty.
                    return '<span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>No job types have been specified</span>';
                }
            })
            // Tradespersons.
            ->addColumn('tradespersons', function ($job) {
                // Find all quotes with a survey.
                $selected_quotes = Quote::where('job_id', $job->id)->pluck('id');
                // Find quote tradespersons from the selected quotes.
                $selected_quote_tradespersons = QuoteUser::wherein('quote_id', $selected_quotes)
                    ->distinct('tradesperson_id')
                    ->pluck('tradesperson_id')
                    ->toArray();
                // All tradespersons on quotes with surveys.
                $all_tradespersons = User::find($selected_quote_tradespersons);
                // Check if the all tradesperson variable is null.
                if (!$all_tradespersons->count()) {
                    // Show the to be confirmned badge.
                    $selected_tradespersons = '<span class="badge badge-warning py-2 px-2"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>To Be Confirmed</span>';
                } else {
                    // Check if there is more than one tradesperson.
                    if ($all_tradespersons->count() >= 2) {
                        // Get the first tradesperson name and set it to a variable.
                        $selected_tradespersons = $all_tradespersons->first()->getFullNameAttribute();
                        // Loop through each of the selected tradespersons.
                        foreach($all_tradespersons as $selected_tradesperson) {
                            // Concatinate each name onto the variable.
                            $selected_tradespersons = $selected_tradespersons . ' ' . $selected_tradesperson->getFullNameAttribute();
                        }
                    } else {
                        // there is only 1 tradesperson, set the single tradespersons name.
                        $selected_tradespersons = $all_tradespersons->first()->getFullNameAttribute();
                    }
                }
                // Return the tradespersons name.
                return $selected_tradespersons;
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
            ->rawColumns(['start_date', 'job_type_id', 'tradespersons', 'last_login_date', 'login_count', 'action',])
            ->make(true);
    }
}
