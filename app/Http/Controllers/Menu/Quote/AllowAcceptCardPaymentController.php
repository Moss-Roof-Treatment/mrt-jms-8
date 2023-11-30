<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class AllowAcceptCardPaymentController extends Controller
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Set The Required Variables.
        // Find the required quote.
        $selected_quote = Quote::findOrFail($id);
        // Update the selected quote.
        $selected_quote->update([
            'allow_accept_card_payment' => $selected_quote->allow_accept_card_payment == 1
                ? 0
                : 1
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully toggled the status of allowing the tradesperson to accept a card payment from the customer when the job is completed.');
    }
}
