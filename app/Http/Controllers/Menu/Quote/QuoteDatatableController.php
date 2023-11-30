<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use Yajra\Datatables\Datatables;

class QuoteDatatableController extends Controller
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
        $quotes = Quote::select('id', 'job_id', 'customer_id', 'quote_status_id')
            ->with(['job' => function($q) {
                return $q->select(['id', 'tenant_suburb']);
            }])
            ->with(['quote_status' => function($q) {
                return $q->select(['id', 'title']);
            }])
            ->with(['customer' => function($q) {
                return $q->select(['id', 'first_name', 'last_name']);
            }])
            ->get();

        return Datatables::of($quotes)
            // Count of use field.
            ->editColumn('customer_id', function ($quote) {
                // Customer full name.
                return $quote->customer->getFullNameAttribute();
            })
            // Count of use field.
            ->addColumn('suburb', function ($quote) {
                // Shorten note text.
                return $quote->job->tenant_suburb;
            })
            // Count of use field.
            ->editColumn('quote_status_id', function ($quote) {
                // Quote status title.
                return $quote->quote_status->title;
            })
            // Add options button column.
            ->addColumn('action', function ($quote) {
                // Quote status title.
                return '<a href="'. route('quotes.show', $quote->id).'" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
