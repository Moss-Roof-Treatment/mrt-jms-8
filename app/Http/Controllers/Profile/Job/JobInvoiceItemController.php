<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;

class JobInvoiceItemController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Set The Required Variables.
        $selected_invoice = Invoice::find($request->invoice_id);
        // Create the new model instance.
        InvoiceItem::create([
            'invoice_id' => $selected_invoice->id,
            'job_id' => $selected_invoice->quote->job_id ?? null
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully created a new invoice item.');
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
            'job_id' => 'sometimes|nullable',
            'cost' => 'required',
            'description' => 'required',
            'cost' => 'required|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
        ]);
        // Set The Required Variables.
        // Selected invoice item.
        $selected_invoice_item = InvoiceItem::findOrFail($id);
        // Format the individual item cost.
        $formatted_item_cost = preg_replace('/[.,]/', '', $request->cost) ?? 0; // was "null" now is "0".
        // Format the billable hours.
        $billable_hours = $request->billable_hours ?? 1;
        // Update the selected model instance.
        $selected_invoice_item->update([
            'completed_date' => isset($request->completed_date) ? Carbon::parse($request->completed_date)->startOfDay() : null,
            'start_time' => isset($request->start_time) ? Carbon::createFromFormat('H:i', $request->start_time) : null,
            'end_time' => isset($request->end_time) ? Carbon::createFromFormat('H:i', $request->end_time) : null,
            'cost' => $formatted_item_cost,
            'job_id' => $request->job_id,
            'total_hours' => $request->total_hours,
            'billable_hours' => $billable_hours,
            'description' => ucfirst($request->description),
            'cost_total' => $billable_hours * $formatted_item_cost
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected invoice item.');
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
        $selected_invoice_item = InvoiceItem::findOrFail($id);
        // Delete the selected model instance.
        $selected_invoice_item->delete();
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully deleted the selected invoice item.');
    }
}
