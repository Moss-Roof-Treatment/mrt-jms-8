<?php

namespace App\Http\Controllers\Menu\Invoice;

use App\Http\Controllers\Controller;
use App\Models\QuoteCommission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CommissionDatatableController extends Controller
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
        // Find all commissions.
        $all_commissions = QuoteCommission::where('approval_date', null)
            ->get();

        // Construct the datatable.
        return DataTables::of($all_commissions)
            // Edit the job column.
            ->addColumn('job', function ($commission) {
                // Return the value.
                return $commission?->quote?->job_id;
            })
            // Edit the customer column.
            ->addColumn('customer', function ($commission) {
                // Return the value.
                return $commission?->quote?->customer->getFullNameAttribute() ?? '';
            })
            // Add the total column.
            ->addColumn('quote_status', function ($commission) {
                // Return the value.
                return $commission?->quote?->quote_status->title;
            })
            // Edit the salesperson column.
            ->addColumn('salesperson', function ($commission) {
                // Return the value.
                return $commission?->salesperson->getFullNameTitleAttribute();
            })
            // Add options button column.
            ->addColumn('action', function ($commission) {
                // Return the link to view the html link.
                return '<a href="' . route('invoice-commissions.show', $commission->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            // Set the raw columns.
            ->rawColumns(['action'])
            // Make true.
            ->make(true);
    }
}
