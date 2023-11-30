<?php

namespace App\Http\Controllers\Menu\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class GroupInvoiceDatatableController extends Controller
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
        // Get all of the selected tradespersons invoices and group them by the confirmation number. 
        $selected_invoices = Invoice::where('is_group_paid', 1)
            ->with(['user' => fn ($q) => $q->select('id', 'first_name', 'last_name')])
            ->select(['id', 'confirmation_number', 'total', 'user_id', 'paid_date'])
            ->get()
            ->groupBy('confirmation_number');

        // Construct the datatable.
        return DataTables::of($selected_invoices)
            // Edit the confirmation_number column.
            ->editColumn('confirmation_number', function ($invoices) {
                // Return the value.
                return $invoices->first()->confirmation_number;
            })
            // Edit the confirmation_number column.
            ->editColumn('user_id', function ($invoices) {
                // Return the value.
                return $invoices->first()->user->getFullNameAttribute();
            })
            // Add the total column.
            ->addColumn('total', function ($invoices) {
                // Return the value.
                return '$' . number_format(($invoices->sum('total') / 100), 2, '.', ',');
            })
            // Add the job_status_id column.
            ->addColumn('count', function ($invoices) {
                // Return the value.
                return $invoices->count();
            })
            // Add the paid_date column.
            ->addColumn('paid_date', function ($invoices) {
                // Return the value.
                return date('Y/m/d', strtotime($invoices->first()->paid_date));
            })
            // Add options button column.
            ->addColumn('action', function ($invoices) {
                // Return the link to view the html link.
                return '<a href="' . route('group-invoices.show', $invoices->first()->confirmation_number) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            // Set the raw columns.
            ->rawColumns(['action'])
            // Make true.
            ->make(true);
    }
}
