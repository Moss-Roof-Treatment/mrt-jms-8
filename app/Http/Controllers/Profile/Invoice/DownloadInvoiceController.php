<?php

namespace App\Http\Controllers\Profile\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\System;
use PDF;

class DownloadInvoiceController extends Controller
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
        // Find the required invoice.
        $selected_invoice = Invoice::findOrFail($_GET['selected_invoice_id']);
        // Set The Required Variables.
        // Find the required system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Generate PDF.
        $pdf = PDF::loadView('menu.invoices.pdf.create', compact('selected_system', 'selected_invoice'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait');
        // Make invoice title variable.
        if ($selected_invoice->paid_date == null) {
            // The invoice is not finalised yet, no finalised date in the name.
            $pdf_title = $selected_system->acronym . '-' . $selected_invoice->identifier . '-invoice.pdf';
        } else {
            // The invoice is finalised, show the finalised date in the name.
            $pdf_title = $selected_system->acronym . '-' . $selected_invoice->identifier . '-' . date('d-m-y', strtotime($selected_invoice->finalised_date)) . '-invoice.pdf';
        }
        // Download as pdf.
        return $pdf->download($pdf_title);
    }
}
