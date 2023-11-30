<?php

namespace App\Http\Controllers\Menu\Report;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WrittenOffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Set The Required Variables.
        // All payments count.
        $total_payments_count = Payment::count();
        // All payments that are set to written off.
        $all_written_off_payments = Payment::where('payment_type_id', 3)
            ->count();
        // All payments that are set to written off.
        $all_written_off_payments_sum = Payment::where('payment_type_id', 3)
            ->sum('payment_amount');
        // Number format the sum of the payment amount.
        $all_written_off_payments_sum = '$' . number_format(($all_written_off_payments_sum) / 100, 2, '.', ',');
        // All payments that are set to written off.
        $all_non_written_off_payments = $total_payments_count - $all_written_off_payments;
        // Return the index view.
        return view('menu.reports.writtenOff.index', [
            'total_payments_count' => $total_payments_count,
            'all_written_off_payments' => $all_written_off_payments,
            'all_non_written_off_payments' => $all_non_written_off_payments,
            'all_written_off_payments_sum' => $all_written_off_payments_sum,
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
                ->route('written-off-report.index')
                ->with('warning', 'Please select a starting date that is before the end date to filter the selected report.');
        }

        // Total jobs.
        $total_payments_count = Payment::whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Unsold jobs.
        $non_written_off_payments_count = Payment::where('payment_type_id', '!=', 3) // quote request, new, pending.
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Sold jobs.
        $written_off_payments_count = Payment::where('payment_type_id', 3) // not quote request, new, pending.
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();

        // Return the index view.
        return view('menu.reports.writtenOff.show')
            ->with([
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_payments_count' => $total_payments_count,
                'non_written_off_payments_count' => $non_written_off_payments_count,
                'written_off_payments_count' => $written_off_payments_count,
            ]);
    }
}
