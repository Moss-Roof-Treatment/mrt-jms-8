<?php

namespace App\Http\Controllers\Profile\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Auth;
use Yajra\Datatables\Datatables;

class PaidInvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAnyStaffMember');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all new selected tradespersons quotes.
        $paid_invoices = Invoice::where('user_id', Auth::id())
            ->where('paid_date', '!=', null) // Paid.
            ->select('id', 'identifier', 'quote_id', 'submission_date')
            ->with(['quote' => fn ($q) => $q->select('id', 'job_id','customer_id')])
            ->with(['quote.job' => fn ($q) => $q->select('id', 'tenant_suburb','tenant_postcode')])
            ->with(['quote.customer' => fn ($q) => $q->select('id', 'first_name','last_name')])
            ->get();

        // Construct the datatable.
        return Datatables::of($paid_invoices)
            // Edit the ID field.
            ->editColumn('id', function ($paid_invoice) {
                // Return the link to view the html link.
                return '<a href="' . route('profile-paid-invoices.show', $paid_invoice->id) . '">' . $paid_invoice->identifier . '</a>';
            })
            // Edit the quote_id field.
            ->editColumn('quote_id', function ($paid_invoice) {
                // Check if the quote id exists.
                if ($paid_invoice->quote_id == null) {
                    // Show the not applicable message.
                    return '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // Customer full name.
                    return $paid_invoice->quote->job_id;
                }
            })
            // Add the suburb field.
            ->addColumn('suburb', function ($paid_invoice) {
                // Check if the quote id exists.
                if ($paid_invoice->quote_id == null) {
                    // Show the not applicable message.
                    return '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // Shorten note text.
                    return $paid_invoice->quote->job->tenant_suburb . ', ' . $paid_invoice->quote->job->tenant_postcode;
                }
            })
            // Edit the job_status_id field.
            ->addColumn('customer', function ($paid_invoice) {
                // Check if the quote id exists.
                if ($paid_invoice->quote_id == null) {
                    // Show the not applicable message.
                    return '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // Quote status title.
                    return $paid_invoice->quote->customer->getFullNameAttribute();
                }
            })
            // Edit the job_type_id field.
            ->editColumn('submission_date', function ($paid_invoice) {
                // Check if the paid date is null.
                if ($paid_invoice->submission_date == null) {
                    // The submission_date is null.
                    return '<span class="badge badge-warning py-2 px-2"><i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending</span>';
                } else {
                    // The submission_date is not null.
                    return date('d/m/y - h:iA', strtotime($paid_invoice->submission_date));
                }
            })
            // Add options button column.
            ->addColumn('action', function ($paid_invoice) {
                // Return the link to view the html link.
                return '<a href="' . route('profile-paid-invoices.show', $paid_invoice->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            ->rawColumns(['id', 'action', 'quote_id', 'suburb', 'customer', 'submission_date'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required model instance.
        $selected_paid_invoice = Invoice::findOrFail($id);
        // Update the required session variables.
        // Pull old session variable.
        if (session()->has('selected_invoice_id')) {
            session()->pull('selected_invoice_id');
        }
        // Set new session variable.
        session([
            'selected_invoice_id' => $id,
        ]);
        // Return the show view.
        return view('profile.invoices.paid.show')
            ->with('selected_paid_invoice', $selected_paid_invoice);
    }
}
