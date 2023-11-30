<?php

namespace App\Http\Controllers\Menu\Quote\Filtered;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use Yajra\Datatables\Datatables;

class DefaultDatableController extends Controller
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
        // Get the required model instance.
        $quotes = Quote::where('quote_status_id', session('filtered_quote_status_id'))
            ->with('job')
            ->with('quote_status')
            ->with('customer')
            ->get();
        // Create the datatable.
        return Datatables::of($quotes)
            // Count of use field.
            ->editColumn('customer_id', function ($quote) {
                // Customer full name.
                return $quote->customer->getFullNameAttribute();
            })
            // Count of use field.
            ->addColumn('suburb', function ($quote) {
                // Suburb.
                return $quote->job->tenant_suburb;
            })
            // Count of use field.
            ->editColumn('quote_status_id', function ($quote) {
                // quote status title.
                return $quote->quote_status->title;
            })
            // Add options button column.
            ->addColumn('action', 'menu.quotes.actions.actions')
            ->rawColumns(['action'])
            ->make(true);
    }
}
