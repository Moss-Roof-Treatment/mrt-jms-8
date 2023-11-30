<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteRate;

class RateController extends Controller
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
        // Find the required model instance.
        $selected_quote_rate = QuoteRate::findOrFail($id);
        // Format the individual price from the request.
        $individual_price = preg_replace('/[$.,]/', '', $request->price);
        // Update the selected model instance.
        $selected_quote_rate->update([
            'individual_price' => $individual_price,
            'total_price' => $individual_price * $selected_quote_rate->quantity,
            'description' => $request->description
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected quote rate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required model instance.
        $selected_quote_rate = QuoteRate::findOrFail($id);
        // Set the quote id variable.
        $selected_quote_id =  $selected_quote_rate->quote_id;
        // Deleted the selected model instance.
        $selected_quote_rate->delete();
        // Return a redirect to the quote show view.
        return redirect()
            ->route('quotes.show', $selected_quote_id)
            ->with('success', 'You have successfully deleted the selected quote rate.');
    }
}
