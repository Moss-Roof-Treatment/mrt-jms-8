<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Customer\DepositReceived;
use App\Mail\Customer\PaidReceipt;
use App\Models\Event;
use App\Models\ExpectedPaymentMethod;
use App\Models\Payment;
use App\Models\Quote;
use App\Models\System;
use App\Models\Note;
use Auth;
use Carbon\Carbon;
use PDF;

class PaymentController extends Controller
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
        // ??????? Does this needs to be made as it is never used anywhere.



        // Find the required model instance.
        // Find the required payment.
        $selected_payment = Payment::find($_GET['selected_payment_id']);
        // Find the required system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Make the PDF file.
        // Create the footer object.
        $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';
        // Generate PDF.
        $pdf = PDF::loadView('menu.quotes.payments.pdf.create', compact('selected_payment', 'selected_system'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait')
            ->setOption('footer-html', $footer);
        // Make Quote Title variable.
        $pdf_title = $selected_payment->payment_date == null 
            // The quote is not finalised yet, no finalised date in the name.
            ? $selected_system->acronym . '-payment.pdf'
            // The quote is finalised, show the finalised date in the name.
            : $selected_system->acronym . '-' . date('d-m-y', strtotime($selected_payment->payment_date)) . '-payment.pdf';
        // Download the pdf file.
        return $pdf->download($pdf_title);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check which payment type has been entered, Deposit or Payment.
        switch ($request->action) {

            // The payment type deposit was selected.
            case 'deposit':
                // Validate The Request Data.
                $request->validate([
                    'deposit_date' => 'required|date',
                    'deposit_method' => 'required|integer',
                    'deposit_amount' => 'required|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
                ]);
                // Format the deposit amount from the request.
                $new_payment_amount = preg_replace('/[$.,]/', '', $request->deposit_amount);
                // Find the required quote.
                $selected_quote = Quote::find($request->selected_quote_id);
                // Set the remaining balance.
                $remaining_balanace = $selected_quote->getRemainingBalance() - $new_payment_amount;
                // Set the expected payment method.
                $selected_expected_payment_method = ExpectedPaymentMethod::where('payment_type_id', 1) // Deposit.
                    ->where('payment_method_id', $request->deposit_method) // Entered payment method.
                    ->firstOrFail();
                // Create the new payment model instance.
                $selected_payment = Payment::create([
                    'quote_id' => $selected_quote->id,
                    'staff_id' => Auth::id(),
                    'payment_method_id' => $request->deposit_method,
                    'payment_type_id' => 1, // Deposit.
                    'payment_amount' => $new_payment_amount,
                    'remaining_amount' => $remaining_balanace,
                    'payment_date' => Carbon::createFromFormat('Y-m-d', $request->deposit_date) // Entered date.
                ]);
                // Update the selected quote.
                $selected_quote->update([
                    'quote_status_id' => 3, // Sold (Deposit Paid).
                    'expected_payment_method_id' => $selected_expected_payment_method->id,
                    'deposit_accepted_date' => $selected_quote->deposit_accepted_date == null 
                        ? Carbon::now()
                        : $selected_quote->deposit_accepted_date
                ]);
                // Update the selected job.
                $selected_quote->job->update([
                    'job_status_id' => 5 // Sold (Deposit Paid).
                ]);

                // Update The Calendar Event.
                // The calendar event may not have the quote_id set, so set it now that the deposit has been paid.
                $selected_event = Event::where('job_id', $selected_quote->job_id)
                    ->first();
                // Check if the event exists.
                if($selected_event != null) {
                    // The event exists.
                    // Update the quote id on the event.
                    $selected_event->update([
                        'quote_id' => $selected_quote->id 
                    ]);
                }

                // Create the new note.
                Note::create([
                    'job_id' => $selected_quote->job_id,
                    'text' => 'Deposit received on ' . $selected_payment->getFormattedCreationDate() . ' - ' . Auth::user()->getFullNameAttribute() . '.',
                    'is_internal' => 1,
                    'jms_seen_at' => Carbon::now(),
                    'jms_acknowledged_at' => Carbon::now(),
                ]);
                // Send Email.
                // Check if notify customer via email checkbox is checked and the customer has an email address.
                if (isset($request->notify_customer_via_email) && $selected_quote->customer->email != null) {
                    // Create the data array to populate the emails with.
                    $data = [
                        'recipient_name' => $selected_quote->customer->getFullNameAttribute()
                    ];
                    // Send the email.
                    Mail::to($selected_quote->customer->email)
                        ->send(new DepositReceived($data));
                    // Create the note.
                    Note::create([
                        'job_id' => $selected_quote->job_id,
                        'text' => '"Deposit Confirmation" email sent to customer - ' . Auth::user()->getFullNameAttribute() . '.',
                        'is_internal' => 1,
                        'jms_seen_at' => Carbon::now(),
                        'jms_acknowledged_at' => Carbon::now()
                    ]);
                    // Return the redirect with success message
                    return back()
                        ->with('success', 'You have successfully created a new quote deposit payment and notified the customer via email.');
                }
            break;

            // The payment type payment was selected.
            case 'payment':
                // Validate The Request Data.
                $request->validate([
                    'payment_date' => 'required|date',
                    'payment_method' => 'required|integer',
                    'payment_amount' => 'required|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
                ]);
                // Format the deposit amount from the request.
                $new_payment_amount = preg_replace('/[$.,]/', '', $request->payment_amount);
                // Find the required quote.
                $selected_quote = Quote::find($request->selected_quote_id);
                // Set the remaining balance.
                $remaining_balanace = $selected_quote->getRemainingBalance() - $new_payment_amount;
                // Create the new payment model instance.
                $selected_payment = Payment::create([
                    'quote_id' => $selected_quote->id,
                    'staff_id' => Auth::id(), 
                    'payment_method_id' => $request->payment_method,
                    'payment_type_id' => 2,
                    'payment_amount' => $new_payment_amount,
                    'remaining_amount' => $remaining_balanace,
                    'payment_date' => Carbon::createFromFormat('Y-m-d', $request->payment_date) // Entered date.
                ]);
                // Update the quote status to deposit paid.
                $selected_quote->update([
                    'remaining_balance_accepted_date' => $selected_quote->remaining_balance_accepted_date == null
                        ? Carbon::now()
                        : null,
                    'quote_status_id' => $selected_quote->getRemainingBalance() != 0
                        ? $selected_quote->quote_status_id // The current value.
                        : 7, // Paid.
                    'expected_payment_method_id' => $selected_quote->getRemainingBalance() != 0 
                        ? $selected_quote->expected_payment_method_id // The current value.
                        : 12, // Paid In Full.
                ]);

                // Update the commission items.
                $selected_quote->updateAllQuoteCommissions();

                // Update the selected job.
                $selected_quote->job->update([
                    'job_status_id' => $selected_quote->getRemainingBalance() != 0
                        ? $selected_quote->job->job_status_id // The current value.
                        : 9, // Paid.
                ]);
                // Create the payment received note.
                Note::create([
                    'job_id' => $selected_quote->job_id,
                    'text' => 'Payment received on ' . $selected_payment->getFormattedCreationDate() . ' - ' . Auth::user()->getFullNameAttribute() . '.',
                    'is_internal' => 1,
                    'jms_seen_at' => Carbon::now(),
                    'jms_acknowledged_at' => Carbon::now()
                ]);
                // Send Email.
                // Check if notify customer via email checkbox is checked and the customer has an email address.
                if (isset($request->notify_customer_via_email) && $selected_quote->customer->email != null) {
                    // Create the data array to populate the emails with.
                    $data = [
                        'recipient_name' => $selected_quote->customer->getFullNameAttribute()
                    ];
                    // Send the email.
                    Mail::to($selected_quote->customer->email)
                        ->send(new PaidReceipt($data));
                    // Return a redirect with success message
                    return back()
                        ->with('success', 'You have successfully created a new quote payment and notified the customer via email.');
                }
            break;
        }

        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully created a new quote payment without notifying the customer.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // This is the generic view payment button.
        // Find the required model instance.
        $selected_payment = Payment::findOrFail($id);
        // Find the required system model instance.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Return the show view.
        return view('menu.quotes.payments.show')
            ->with([
                'selected_payment' => $selected_payment,
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
        $selected_payment = Payment::findOrFail($id);
        // Check the selected model void date status.
        switch ($selected_payment->void_date) {
            // If the void date is null.
            case null:
                // IF PAYMENT IS CURRENTLY ACTIVE
                // Set the current time with carbon.
                $selected_payment->update([
                    'void_date' => Carbon::now()
                ]);
                // Return a redirect back.
                return redirect()
                    ->route('quote-payments.show', $id)
                    ->with('warning', 'You have successfully voided the selected payment.');
            break;
            // If the void date is not null.
            case true:
                // IF PAYMENT IS CURRENTLY VOID
                // Set the current time to null.
                $selected_payment->update([
                    'void_date' => null
                ]);
                // Return a redirect back.
                return redirect()
                    ->route('quote-payments.show', $id)
                    ->with('success', 'You have successfully validated the selected payment.');
            break;
        }
    }
}
