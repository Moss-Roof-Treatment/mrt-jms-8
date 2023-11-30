<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\System;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class DownloadPreReceiptController extends Controller
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
        // Check if the GET data has been supplied.
        if(!isset($_GET['selected_quote_id'])) {
            return back()
                ->with('danger', 'The job information is required to create a pre-receipt.');
        }
        // Find the required quote.
        $selected_quote = Quote::find($_GET['selected_quote_id']);
        // Set The Required Variables.
        // Find the required system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Set fallback date for the possibility that the final receipt date has not been set.
        $default_date = date('d/m/y', strtotime(Carbon::now()));
        // Create the footer object.
        $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';
        // Generate PDF.
        $pdf = PDF::loadView('profile.jobs.preReceipt.create', compact('selected_quote', 'selected_system', 'default_date'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait')
            ->setOption('footer-html', $footer);
        // Make Quote Title variable.
        if ($selected_quote->final_receipt_date == null) {
            // The quote is not finalised yet, no finalised date in the name.
            $pdf_title = $selected_system->acronym . '-pre-receipt.pdf';
        } else {
            // The quote is finalised, show the finalised date in the name.
            $pdf_title = $selected_system->acronym . '-' . date('d-m-y', strtotime($selected_quote->final_receipt_date)) . '-pre-receipt.pdf';
        }
        // Download as pdf.
        return $pdf->download($pdf_title);
    }
}
