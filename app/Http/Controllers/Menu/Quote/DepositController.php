<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\Customer\DepositReceipt;
use App\Models\Note;
use App\Models\Quote;
use App\Models\System;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PDF;

class DepositController extends Controller
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

        // Create the footer object.
        $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';

        // Generate PDF.
        $pdf = PDF::loadView('menu.quotes.deposit.pdf.create', compact('selected_quote', 'selected_system'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait')
            ->setOption('footer-html', $footer);

        // Set The PDF Title
        // The date used is the date the document is created not the date it was paid.
        $pdf_title = $selected_system->acronym . '-deposit-receipt-' . Carbon::now()->format('d-m-Y') . '.pdf';

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
        // This is the "View Deposit" button on the finalised quote page.
        // Find the required model instance.
        $selected_quote = Quote::findOrFail($id);
        // Find the required system model instance.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Return the show view.
        return view('menu.quotes.deposit.show')
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
        // Find the required model instance.
        $selected_quote = Quote::findOrFail($id);
        // Check the selected model void date status.
        switch ($request->action) {
            // If the email action button has been clicked.
            case 'email':
                // Find the required system model instance.
                $selected_system = System::firstOrFail(); // Moss Roof Treatment.
                // Create the footer object.
                $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';
                // Generate PDF.
                $pdf = PDF::loadView('menu.quotes.deposit.pdf.create', compact('selected_quote', 'selected_system'))
                    ->setOption('encoding', 'UTF-8')
                    ->setOption('orientation', 'portrait')
                    ->setOption('footer-html', $footer);
                // Make Quote Title variable.
                if ($selected_quote->tax_invoice_date == null) {
                    // The quote is not finalised yet, no finalised date in the name.
                    $pdf_title = $selected_system->acronym . '-deposit.pdf';
                } else {
                    // The quote is finalised, show the finalised date in the name.
                    $pdf_title = $selected_system->acronym . '-' . date('d-m-y', strtotime($selected_quote->tax_invoice_date)) . '-deposit.pdf';
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
                        ->send(new DepositReceipt($data));
                    // Create the new note
                    Note::create([
                        'job_id' => $selected_quote->job_id,
                        'text' => '"DEPOSIT RECEIPT PDF" email sent to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
                        'is_internal' => 1,
                        'jms_seen_at' => Carbon::now(),
                        'jms_acknowledged_at' => Carbon::now(),
                    ]);
                }
                // Set the quote as depost receipt as emailed.
                $selected_quote->update([
                    'deposit_emailed' => 1
                ]);
                // Return a redirect back.
                return back()
                    ->with('warning', 'You have successfully finalised and emailed the deposit receipt to the customer.');
            break;
            // If the post action button has been clicked.
            case 'post':
                // Create the new note
                Note::create([
                    'job_id' => $selected_quote->job_id,
                    'text' => '"DEPOSIT RECEIPT" posted to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
                    'is_internal' => 1,
                    'jms_seen_at' => Carbon::now(),
                    'jms_acknowledged_at' => Carbon::now()
                ]);
                // Set the quote as depost receipt as mailed.
                $selected_quote->update([
                    'deposit_posted' => 1
                ]);
                // Return a redirect back.
                return back()
                    ->with('success', 'You have successfully finalised and marked the deposit receipt as posted to the customer.');
            break;
            // The default catch action.
            default:
                // Return a 404.
                return abort(404);
        }
    }
}
