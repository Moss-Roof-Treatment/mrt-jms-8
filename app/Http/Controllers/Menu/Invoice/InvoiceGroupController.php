<?php

namespace App\Http\Controllers\Menu\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PayAsYouGoTax;
use App\Models\System;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PDF;

class InvoiceGroupController extends Controller
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
        // Find the required model instance.
        $selected_user = User::findOrFail($_GET['selected_user_id']);
        // Find the required system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Get all invoices marked as confirmed by staff.
        $invoices = $selected_user->getOutstandingConfirmedInvoiceModels()->pluck('id')->toArray();
        // Find all required invoice items.
        $invoice_items = InvoiceItem::whereIn('invoice_id', $invoices)->get();
        // Item total.
        $item_cost_total = $invoice_items->sum('cost_total');
        // GST
        $item_gst = $selected_user->has_gst == null ? 0 : $item_cost_total * $selected_system->getDefaultTaxValue();
        // PAYG
        $item_payg = $selected_user->has_payg == null ? 0 : $selected_user->getOutstandingConfirmedInvoiceModels()->sum('payg');
        // Superannuation.
        $item_superannuation = $selected_user->super_fund_name == null ? 0 : $item_cost_total * $selected_system->getDefaultSuperannuationValue();
        // Invoices total amount.
        $invoces_total = $item_cost_total + $item_gst;

        // Generate PDF.
        $pdf = PDF::loadView('menu.invoices.group.pdf.create', compact('selected_system', 'selected_user', 'invoice_items', 'item_cost_total', 'item_gst', 'item_payg', 'item_superannuation', 'invoces_total'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait');
        // Set the PDF title.
        $pdf_title = $selected_system->acronym . '-' . Str::slug($selected_user->getFullNameAttribute()) . '-group-invoice.pdf';
        // Download as pdf.
        return $pdf->download($pdf_title);
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
        $selected_user = User::find($id);
        // Get the systems variables.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Get all invoices marked as confirmed by staff.
        $invoices = $selected_user->getOutstandingConfirmedInvoiceModels()->pluck('id')->toArray();
        // Find all required invoice items.
        $invoice_items = InvoiceItem::whereIn('invoice_id', $invoices)->get();
        // Item total.
        $item_cost_total = $invoice_items->sum('cost_total');
        // GST
        $item_gst = $selected_user->has_gst == null ? 0 : $item_cost_total * $selected_system->getDefaultTaxValue();
        // Superannuation.
        $item_superannuation = $selected_user->super_fund_name == null ? 0 : $item_cost_total * $selected_system->getDefaultSuperannuationValue();
        // Invoices total amount.
        $invoces_total = $item_cost_total + $item_gst;
        // return the show view.
        return view('menu.invoices.group.show')
            ->with([
                'selected_user' => $selected_user,
                'item_cost_total' => $item_cost_total,
                'item_gst' => $item_gst,
                'item_superannuation' => $item_superannuation,
                'invoces_total' => $invoces_total,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate The Request Data.
        $request->validate([
            'confirmation_number' => 'required|unique:invoices,confirmation_number',
            'confirmation_date' => 'required',
            'payg' => 'sometimes|nullable|string',
        ]);
        // Find all the required model instances.
        $selected_invoices = Invoice::where('user_id', $id)
            ->where('confirmed_date', '!=', null)
            ->where('paid_date', null)
            ->get();
        // Set The Required Variables.
        // Parse the entered date with carbon.
        $formatted_confirmation_date = Carbon::parse($request->confirmation_date)->startOfDay();
        // Loop through each invoice.
        foreach($selected_invoices as $invoice) {
            // Update the selected model instance.
            $invoice->update([
                'paid_date' => $formatted_confirmation_date,
                'submission_date' => $invoice->submission_date == null ? $formatted_confirmation_date : $invoice->submission_date,
                'confirmed_date' => $invoice->confirmed_date == null ? $formatted_confirmation_date : $invoice->confirmed_date,
                'confirmation_number' => $request->confirmation_number,
                'is_group_paid' => 1,
            ]);
        }
        // Create the new PAYG model instance
        PayAsYouGoTax::create([
            'confirmation_number' => $request->confirmation_number,
            'amount' => intval(preg_replace('/[$.,]/', '', $request->payg))
        ]);
        // return a redirect to the index view.
        return redirect()
            ->route('invoices-outstanding.index')
            ->with('success', 'You have successfully marked all of the selected invoices as paid.');
    }
}
