<?php

namespace App\Http\Controllers\Profile\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PayAsYouGoTax;
use App\Models\System;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;

class GroupInvoiceController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return the index view.
        return view('profile.invoices.group.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Get the systems variables.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Find all invoices with the required confirmation number.
        $selected_invoices = Invoice::where('confirmation_number', $_GET['selected_confirmation_number'])
            ->get();
        // Find the required model instance.
        $selected_user = User::find(Auth::id());
        // All Invoice IDs.
        $invoice_ids = $selected_invoices->pluck('id')->toArray();

        // Find all required invoice items.
        $invoice_items = InvoiceItem::whereIn('invoice_id', $invoice_ids)->get();
        // Item total.
        $item_cost_total = $invoice_items->sum('cost_total');
        // GST
        $item_gst = $selected_user->has_gst == null ? 0 : $item_cost_total * $selected_system->getDefaultTaxValue();
        // PAYG
        $item_payg = PayAsYouGoTax::where('confirmation_number', $_GET['selected_confirmation_number'])->first()->amount ?? 0;
        // Superannuation.
        $item_superannuation = $selected_user->super_fund_name == null ? 0 : $item_cost_total * $selected_system->getDefaultSuperannuationValue();
        // Invoices total amount.
        // $invoces_total = $item_cost_total + $item_gst;
        $invoces_total = $item_cost_total + $item_gst - $item_payg;

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
        // Set The Required Variables.
        // Get the systems variables.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Find all invoices with the required confirmation number.
        $selected_invoices = Invoice::where('confirmation_number', $id)
            ->get();
        // Find the required model instance.
        $selected_user = User::find(Auth::id());
        // All Invoice IDs.
        $invoice_ids = $selected_invoices->pluck('id')->toArray();

        // Find all required invoice items.
        $invoice_items = InvoiceItem::whereIn('invoice_id', $invoice_ids)->get();
        // Item total.
        $item_cost_total = $invoice_items->sum('cost_total');
        // GST
        $item_gst = $selected_user->has_gst == null ? 0 : $item_cost_total * $selected_system->getDefaultTaxValue();
        // PAYG
        $item_payg = PayAsYouGoTax::where('confirmation_number', $id)->first()->amount ?? 0;
        // Superannuation.
        $item_superannuation = $selected_user->super_fund_name == null ? 0 : $item_cost_total * $selected_system->getDefaultSuperannuationValue();
        // Invoices total amount.
        $invoces_total = $item_cost_total + $item_gst - $item_payg;

        // Return the show view.
        return view('profile.invoices.group.show', [
            'selected_invoices' => $selected_invoices,
            'item_cost_total' => $item_cost_total,
            'item_gst' => $item_gst,
            'item_payg' => $item_payg,
            'item_superannuation' => $item_superannuation,
            'invoces_total' => $invoces_total,
            'selected_user' => $selected_user,
            'selected_confirmation_number' => $id,
        ]);
    }
}
