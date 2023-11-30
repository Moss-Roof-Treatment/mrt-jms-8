<?php

namespace App\Http\Controllers\Menu\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Payment;
use Carbon\Carbon;

class CashPaymentsStatisticsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isSuperUser');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Set The Required Variables.
        // Total quotes.
        $total_quotes = Quote::whereIn('quote_status_id', [7,12]) // 7 = Paid, 12 = Payment Received.
            ->count();
        // Jobs set as paid cash.
        $cash_quotes_count = Quote::where('quote_status_id', 12) // 12 = Payment Received.
            ->count();

        $cash_value = Payment::whereHas('quote', fn ($q) => $q->where('quote_status_id', 12)) // 12 = Payment Received.
            ->where('payment_method_id', 2) // 2 = Cash.
            ->sum('payment_amount');

        // Return the index view.
        return view('menu.reports.cashStatistics.index')
            ->with([
                'cash_quotes_count' => $cash_quotes_count,
                'cash_value' => $cash_value,
                'total_quotes' => $total_quotes,
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
            return back()
                ->with('warning', 'Please select a starting date that is before the end date to filter the selected report.');
        }

        // Total quotes.
        $total_quotes_count = Quote::whereIn('quote_status_id', [4,5,6,7,8,9]) // not quote request, new, pending.
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Unsold quotes.
        $cash_quotes_count = Quote::where('quote_status_id', 12) // only 'payment received' status.
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        $cash_value = Payment::whereHas('quote', fn ($q) => $q->where('quote_status_id', 12)) // 12 = Payment Received.
            ->where('payment_method_id', 2) // 2 = Cash.
            ->whereBetween('created_at', [$start_date, $end_date])
            ->sum('payment_amount');

        // Return the index view.
        return view('menu.reports.cashStatistics.results')
            ->with([
                'cash_value' => $cash_value,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_quotes_count' => $total_quotes_count,
                'cash_quotes_count' => $cash_quotes_count,
            ]);
    }
}
