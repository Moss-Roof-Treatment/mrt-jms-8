<?php

namespace App\Http\Controllers\Menu\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use Carbon\Carbon;

class CustomerReferralController extends Controller
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
        // Get the total count of all customer users that have a not null referral_id. 
        $total_customer_referrals = Quote::count();
        // Get the total count of all quotes with a sold status.
        $total_sold_quotes = Quote::whereIn('quote_status_id', [3, 4, 5, 6, 7])
            ->count();
        // Get all quotes with the required status
        $sold_quotes = Quote::whereIn('quote_status_id', [3, 4, 5, 6, 7])
            ->with('customer')
            ->with('customer.referral')
            ->get()
            ->groupBy('customer.referral_id')->sortByDesc(function($sold_quotes)
            {
                // Count of each group of salespersons.
                return $sold_quotes->count();
            });
        // Return the index view.
        return view('menu.reports.customerReferrals.index')
            ->with([
                'total_customer_referrals' => $total_customer_referrals,
                'sold_quotes' => $sold_quotes,
                'total_sold_quotes' => $total_sold_quotes
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
                ->route('customer-referral-report.index')
                ->with('warning', 'Please select a starting date that is before the end date to filter the selected report.');
        }

        // Total customer referral count.
        $total_customer_referrals = Quote::whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Get the total count of all quotes with a sold status.
        $total_sold_quotes = Quote::whereIn('quote_status_id', [3, 4, 5, 6, 7])
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Get all quotes with the required status
        $all_quotes = Quote::whereBetween('created_at', [$start_date, $end_date])
            ->with('customer')
            ->with('customer.referral')
            ->get()
            ->groupBy('customer.referral_id')->sortByDesc(function($all_quotes)
            {
                // Count of each group of salespersons.
                return $all_quotes->count();
            });

        // Return the index view.
        return view('menu.reports.customerReferrals.results')
            ->with([
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_customer_referrals' => $total_customer_referrals,
                'total_sold_quotes' => $total_sold_quotes,
                'all_quotes' => $all_quotes
            ]);
    }
}
