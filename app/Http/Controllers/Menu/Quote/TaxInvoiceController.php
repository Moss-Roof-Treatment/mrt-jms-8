<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\Customer\TaxInvoice;
use App\Models\Event;
use App\Models\Note;
use App\Models\JobStatus;
use App\Models\Quote;
use App\Models\QuoteTaxInvoiceItem;
use App\Models\System;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PDF;

class TaxInvoiceController extends Controller
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
        // Create a log message.
        Log::info('404 - The selected user has navigated to the index route of a route resource that does not exist.');
        // Return abort 404.
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Find the required quote.
        $selected_quote = Quote::find($_GET['quote_id']);
        // Find the required system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // All quote tax invoice items.
        $all_tax_invoice_items = QuoteTaxInvoiceItem::where('quote_id', $selected_quote->id)
            ->get();

        // Create the footer object.
        $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';

        // Generate PDF.
        $pdf = PDF::loadView('menu.quotes.taxInvoice.pdf.create', compact('selected_quote', 'selected_system', 'all_tax_invoice_items'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait')
            ->setOption('footer-html', $footer);

        // Set The PDF Title
        // The date used is the date the document is created not the date it was paid.
        $pdf_title = $selected_system->acronym . '-tax-invoice-' . Carbon::now()->format('d-m-Y') . '.pdf';

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
        $selected_quote = Quote::findOrFail($id);
        // Find the required system model instance.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Return the show view.
        return view('menu.quotes.taxInvoice.show')
            ->with([
                'selected_quote' => $selected_quote,
                'selected_system' => $selected_system
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
        // FINALISE AND SEND THE TAX INVOICE
        // Set The Required Variables.
        // Find the required quote model instance.
        $selected_quote = Quote::findOrFail($id);
        // Find the required event model instance.
        $selected_event = Event::where('job_id', $selected_quote->job_id)
            ->first();
        // Find the required job status.
        $selected_job_status = JobStatus::find(8); // Invoiced.
        // Check if the tax invoice date has been set.
        if ($selected_quote->tax_invoice_date == null) {
            // Update the selcted model instance.
            $selected_quote->update([
                'tax_invoice_date' => Carbon::now()
            ]);
        }
        // Update the selected job status.
        $selected_quote->job->update([
            // Update the job status to invoiced.
            'job_status_id' => $selected_job_status->id // 8 - Invoiced.
        ]);
        // Check if the selected event does not equal null.
        if ($selected_event != null) {
            // Update the selected event.
            $selected_event->update([
                'description' => 'The job status has been automatically updated to ' . $selected_job_status->title . ' by sending the invoice to the customer by ' . $request->action . '.',
                'color' => $selected_job_status->color,
                'textColor' => $selected_job_status->text_color
            ]);
        }
        // Create the status change note.
        Note::create([
            'job_id' => $selected_quote->job_id,
            'text' => '"JOB STATUS" changed to "Invoiced". - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => 1,
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'jms_seen_at' => Carbon::now(),
            'jms_acknowledged_at' => Carbon::now()
        ]);
        // Check the selected model void date status.
        switch ($request->action) {
            // If the email action button has been clicked.
            case 'email':

                // Find the required system model instance.
                $selected_system = System::firstOrFail(); // Moss Roof Treatment.
                // All quote tax invoice items.
                $all_tax_invoice_items = QuoteTaxInvoiceItem::where('quote_id', $selected_quote->id)
                    ->get();

                // Create the footer object.
                $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';

                // Generate PDF.
                $pdf = PDF::loadView('menu.quotes.taxInvoice.pdf.create', compact('selected_quote', 'selected_system', 'all_tax_invoice_items'))
                    ->setOption('encoding', 'UTF-8')
                    ->setOption('orientation', 'portrait')
                    ->setOption('footer-html', $footer);

                // Make Quote Title variable.
                if ($selected_quote->tax_invoice_date == null) {
                    // The quote is not finalised yet, no finalised date in the name.
                    $pdf_title = $selected_system->acronym . '-tax-invoice.pdf';
                } else {
                    // The quote is finalised, show the finalised date in the name.
                    $pdf_title = $selected_system->acronym . '-' . date('d-m-y', strtotime($selected_quote->tax_invoice_date)) . '-tax-invoice.pdf';
                }

                // Send Email.
                // Check if the selected quote customer has an email address.
                if ($selected_quote->customer->email != null) {
                    // Create the data array to populate the emails with.
                    $data = [
                        'recipient_name' => $selected_quote->customer->getFullNameAttribute(),
                        'pdf_data' => $pdf->output(),
                        'pdf_title' => $pdf_title
                    ];
                    // Send the email.
                    Mail::to($selected_quote->customer->email)
                        ->send(new TaxInvoice($data));
                    // Create the new note
                    Note::create([
                        'job_id' => $selected_quote->job_id,
                        'text' => '"TAX INVOICE" email sent to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
                        'is_internal' => 1,
                        'jms_seen_at' => Carbon::now(),
                        'jms_acknowledged_at' => Carbon::now()
                    ]);
                } else {
                    // There is no email address.
                    return back()
                        ->with('warning', 'The selected customer has no email address to receive the tax invoice email.');
                }
                // Set the quote as depost receipt as emailed.
                $selected_quote->update([
                    'tax_invoice_emailed' => 1
                ]);
                // Return a redirect back.
                return back()
                    ->with('success', 'You have successfully finalised and emailed the tax invoice to the customer.');
            break;
            // If the post action button has been clicked.
            case 'post':
                // Create the new note
                Note::create([
                    'job_id' => $selected_quote->job_id,
                    'text' => '"TAX INVOICE" posted to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
                    'is_internal' => 1,
                    'jms_seen_at' => Carbon::now(),
                    'jms_acknowledged_at' => Carbon::now()
                ]);
                // Set the quote as depost receipt as mailed.
                $selected_quote->update([
                    'tax_invoice_posted' => 1
                ]);
                // Return a redirect back.
                return back()
                    ->with('success', 'You have successfully finalised and marked the tax invoice as posted to the customer.');
            break;
            // The default catch action.
            default:
                // Return a 404.
                return abort(404);
        }
    }
}
