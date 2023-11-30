<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class AllowPreReceiptController extends Controller
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
            'allow_early_receipt' => $selected_quote->allow_early_receipt == 1
                ? 0
                : 1
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully toggled the status of allowing the tradesperson to generate a pre-receipt for the customer.');
    }
}
