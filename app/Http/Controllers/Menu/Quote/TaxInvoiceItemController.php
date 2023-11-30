<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteTaxInvoiceItem;
use App\Models\Quote;

class TaxInvoiceItemController extends Controller
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
        // Validate The Request Data.
        $request->validate([
            'tax_invoice_item_quantity' => 'required|string|min:1|max:4',
            'tax_invoice_item_title' => 'required|string|min:10|max:255',
            'tax_invoice_item_price' => 'required|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
        ]);
        // Format the the price from the request.
        $formatted_price = preg_replace('/[$.,]/', '', $request->tax_invoice_item_price);
        // Create the new model instance.
        QuoteTaxInvoiceItem::create([
            'quote_id' => $request->selected_quote_id,
            'title' => ucfirst($request->tax_invoice_item_title),
            'quantity' => $request->tax_invoice_item_quantity,
            'individual_price' => $formatted_price,
            'total_price' => $request->tax_invoice_item_quantity * $formatted_price
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully created a new tax invoice item.');
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
        $selected_quote_tax_invoice_item = QuoteTaxInvoiceItem::findOrFail($id);
        // Find the required quote model instance.
        $selected_quote = Quote::find($selected_quote_tax_invoice_item->quote_id);
        // Delete the selected model instance.
        $selected_quote_tax_invoice_item->delete();
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully deleted the selected tax invoice item.');
    }
}
