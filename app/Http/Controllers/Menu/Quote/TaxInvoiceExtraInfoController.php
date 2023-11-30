<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;

class TaxInvoiceExtraInfoController extends Controller
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
        // Validate The Request Data.
        $request->validate([
            'description' => 'sometimes|nullable|string',
            'discount' => 'sometimes|nullable|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
        ]);
        // Find the required model instance.
        $selected_quote = Quote::findOrFail($id);
        // Format the deposit amount from the request.
        $discount = $request->discount != null ? preg_replace('/[$.,]/', '', $request->discount) : 0;
        // Update the selected quote model instance.
        $selected_quote->update([
            'tax_invoice_discount' => $discount,
            'tax_invoice_note' => $request->description,
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected quote tax invoice section.');
    }
}
