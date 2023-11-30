<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\ScheduledPayment;
use Carbon\Carbon;

class ScheduledPaymentController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Find the required quote.
        $selected_quote = Quote::find($request->selected_quote_id);
        // Create new scheduled payment.
        ScheduledPayment::create([
            'quote_id' => $selected_quote->id,
            'payment_amount' => preg_replace('/[$.,]/', '', $selected_quote->getTaxInvoiceOpeningBalance()),
            'payment_date' => $selected_quote->tax_invoice_date != null ? $selected_quote->tax_invoice_date : Carbon::now() 
        ]);
        // Return redirect back.
        return back()->with('success', 'You have successfully created a scheduled payment on the selected quote.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $selected_scheduled_payment = ScheduledPayment::find($id);

        $selected_scheduled_payment->delete();

        return back()->with('success', 'success');
    }
}
