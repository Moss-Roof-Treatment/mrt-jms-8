<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Quote;
use App\Models\Payment;
use Auth;
use Carbon\Carbon;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;

class AcceptCardPaymentController extends Controller
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
        // Check if the GET data has been supplied.
        if(!isset($_GET['selected_quote'])) {
            return back()
                ->with('danger', 'The job information is required to process a payment.');
        }
        // Find the required quote.
        $selected_quote = Quote::findOrFail($_GET['selected_quote']);
        // Return the index view.
        return view('profile.jobs.acceptCardPayment.index', [
            'selected_quote' => $selected_quote
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Find the required model instance.
        $selected_quote = Quote::findOrFail($request->quote_id);

        // Set the required variables.
        // PAYMENT VARIABLES
        // Unformatted deposit amount.
        $total_sale = $selected_quote->getFormattedRemainingBalanceTaxInvoice(); // Unformatted payment total inc GST.
        // Formatted deposit total.
        $semi_formatted_total_sale = preg_replace('/[$.,]/', '', $total_sale); // Stip out dollar sign, period and coma.
        // Formatted deposit total.
        $formatted_total_sale = $semi_formatted_total_sale / 100; // divided by 100 to turn cents into dollars.
        // Calculate 1.75% stripe surchage.
        $fee_percent = 0.0175; // 1.75%.
        // Set $0.30 fixed fee.
        $fee_fixed = 0.30; // 30 cents.
        // Calculate the surcharge total using stripes pass fees onto customer equation. 
        $surcharge = ( $formatted_total_sale / ( 1 - $fee_percent )) + ( 1 + ( $fee_percent * $fee_percent ) + $fee_percent ) * $fee_fixed - $formatted_total_sale;
        // Set the charge amount to send to stripe.
        $charge_amount = number_format(($formatted_total_sale + $surcharge), 2, '.', ',');

        // Process the payment.
        // Try to process the payment with stripe.
        try {

            // Create the stripe payment.
            Stripe::charges()->create([
                'amount' => $charge_amount,
                'currency' => 'AUD',
                'source' => $request->stripeToken,
                'description' => 'Remaining balance payment processed by tradesperson, Quote# ' . $selected_quote->quote_identifier,
                'receipt_email' => Auth::user()->email,
            ]);

            // Create the new quote payment.
            Payment::create([
                'quote_id' => $selected_quote->id,
                'staff_id' => 3, // Admin user meaning the auto payment gateway.
                'payment_method_id' => 4, // Card.
                'payment_type_id' => 2, // Payment.
                'payment_amount' => $semi_formatted_total_sale,
                'remaining_amount' => 0, // Set to zero as the card payment pays the total remaining value.
                'has_processing_fee' => 1, // Has stripe payment processing fee.
                'payment_date' => Carbon::now(),
            ]);

            // Update the selected quote.
            $selected_quote->update([
                'quote_status_id' => 7, // Paid.
                'expected_payment_method_id' => 12, // Total Paid.
                'deposit_accepted_date' => $selected_quote->deposit_accepted_date == null ? Carbon::now() : $selected_quote->deposit_accepted_date, // Open job view in self service.
                'remaining_balance_accepted_date' => $selected_quote->remaining_balance_accepted_date == null ? Carbon::now() : $selected_quote->remaining_balance_accepted_date, // Accept balance to pay.
                'tax_invoice_date' => $selected_quote->tax_invoice_date == null ? Carbon::now() : $selected_quote->tax_invoice_date, // Date to appear on tax invoice.
                'final_receipt_date' => $selected_quote->final_receipt_date == null ? Carbon::now() : $selected_quote->final_receipt_date, // Date to appear on final receipt.
            ]);

            // Update the selected job.
            $selected_quote->job->update([
                'quote_status_id' => 9, // Paid.
            ]);

            // Update the commission items.
            $selected_quote->updateAllQuoteCommissions();

            // Make job note.
            Note::create([
                'job_id' => $selected_quote->job_id,
                'sender_id' => Auth::id(), // Set the customer id as the sender id so that it shows in the customer note counter and filter.
                'priority_id' => 2, // Important.
                'is_internal' => 1, // Is Internal.
                'text' => 'Quote "#' . $selected_quote->quote_identifier . '" has been paid in full via the tradesperson payment gateway' . ' - ' . Auth::user()->getFullNameAttribute()
            ]);

            // Return a redirect to the job show route.
            return redirect()
                ->route('profile-jobs.show', $selected_quote->id)
                ->with('success', 'The payment has been accepted successfully, The selected job is now paid in full.');

        // Catch any errors that may occour.
        } catch (CardErrorException $e) {

            // Return a redirect back and display the errors that have occoured.
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }
}
