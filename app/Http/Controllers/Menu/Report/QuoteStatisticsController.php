<?php

namespace App\Http\Controllers\Menu\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use Carbon\Carbon;

class QuoteStatisticsController extends Controller
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
        $total_quotes_count = Quote::count();
        // Unsold jobs.
        $unsold_quotes_count = Quote::whereIn('quote_status_id', [1,2,8,9]) // New and not given.
            ->count();
        // Sold jobs.
        $sold_quotes_count = Quote::whereIn('quote_status_id', [3, 4, 5, 6, 7]) // Not new or not given.
            ->count();
        // Return the index view.
        return view('menu.reports.quoteStatistics.index')
            ->with([
                'total_quotes_count' => $total_quotes_count,
                'sold_quotes_count' => $sold_quotes_count,
                'unsold_quotes_count' => $unsold_quotes_count
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
                ->route('quote-statistics-report.index')
                ->with('warning', 'Please select a starting date that is before the end date to filter the selected report.');
        }

        // Total jobs.
        $total_quotes_count = Quote::whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Unsold jobs.
        $unsold_quotes_count = Quote::whereIn('quote_status_id', [1,2,8,9]) // New and not given.
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Sold jobs.
        $sold_quotes_count = Quote::whereIn('quote_status_id', [3, 4, 5, 6, 7]) // Not new or not given.
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Return the index view.
        return view('menu.reports.quoteStatistics.results')
            ->with([
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_quotes_count' => $total_quotes_count,
                'sold_quotes_count' => $sold_quotes_count,
                'unsold_quotes_count' => $unsold_quotes_count
            ]);
    }
}
