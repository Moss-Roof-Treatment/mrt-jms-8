<?php

namespace App\Http\Controllers\Menu\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\QuoteCommission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConvertCommissionToInvoiceController extends Controller
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
        // Find all commissions.
        $selected_commission = QuoteCommission::find($id);

        // Set the required variables.
        // Find the required user.
        $selected_user = User::find($selected_commission->salesperson_id);
        // Previous invoice count.
        $previous_invoice_count = Invoice::where('user_id', $selected_user->id)
            ->count();
        // Create the new model instance.
        // Set the required variables for generating the invoice identifier.
        // Uppercase of first letter of first name.
        $first_name_letter = strtoupper(substr($selected_user->first_name, 0, 1));
        // Uppercase of first letter of first name.
        $last_name_letter = strtoupper(substr($selected_user->last_name, 0, 1));
        // First letter of the account role type.
        $account_role_letter = strtoupper(substr($selected_user->account_role->title, 0, 1));
        // Set the invoice item cost.
        $invoice_item_cost = $selected_commission->edited_total == null
            ? $selected_commission->quote_total * $selected_commission->individual_percent_value
            : $selected_commission->edited_total;

        // Create new invoice.
        $new_invoice = Invoice::create([
            'quote_id' => $selected_commission->quote_id,
            'user_id' => $selected_user->id,
            'identifier' => $first_name_letter . $last_name_letter . $account_role_letter . ++$previous_invoice_count,
            'subtotal' => $invoice_item_cost,
            'total' => $invoice_item_cost,
            'finalised_date' => now(),
            'submission_date' => now(),
        ]);

        // Create new invoice item for the newly created invoice.
        InvoiceItem::create([
            'invoice_id' => $new_invoice->id,
            'job_id' => $selected_commission->quote->job_id,
            'cost' => $invoice_item_cost,
            'billable_hours' => 1,
            'cost_total' => $invoice_item_cost,
            'description' => 'Commission for job number ' . $selected_commission->quote->quote_identifier
        ]);

        // Mark the commission object as converted.
        $selected_commission->update([
            'invoice_id' => $new_invoice->id,
            'approval_date' => now()
        ]);

        // Return a redirect back.
        return redirect()
            ->route('invoice-commissions.index')
            ->with('success', 'You have successfully converted the selected commission into an invoice.');
    }
}
