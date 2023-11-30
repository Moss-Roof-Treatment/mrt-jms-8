<?php

namespace App\Http\Controllers\Menu\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Auth;

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
        $all_paid_invoices = Invoice::where('paid_date', '!=', null) // Paid.
            ->select('id', 'identifier', 'submission_date', 'quote_id', 'user_id')
            ->with('quote')
            ->with(['quote.customer' => fn ($q) => $q->select('id', 'first_name', 'last_name')])
            ->with(['user' => fn ($q) => $q->select('id', 'first_name', 'last_name')])
            ->get();
        // Return the index view.
        return view('menu.invoices.paid.index')
            ->with('all_paid_invoices', $all_paid_invoices);
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
        // Secondary validation.
        if (Auth::user()->account_role_id == 2 && $selected_paid_invoice->user_id != Auth::id()) { // Check if the account staff and the user belonging to the invoice.
            // The auth user is a staff memeber and invoice does not belong to them.
            // Return a redirect back.
            return back()
                ->with('danger', 'You do not have the correct permissions to access this invoice.');
        }
        // Return the index view.
        return view('menu.invoices.paid.show')
            ->with('selected_paid_invoice', $selected_paid_invoice);
    }
}
