<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Carbon\Carbon;

class SubmitInvoiceController extends Controller
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the required model instance.
        $selected_invoice = Invoice::findOrFail($id);
        // Update the selected model instance.
        $selected_invoice->update([
            'finalised_date' => $selected_invoice->finalised_date == null ? Carbon::now() : $selected_invoice->finalised_date,
            'submission_date' => Carbon::now()
        ]);
        // Return redirect to the profile invoices index route.
        return redirect()
            ->route('profile-invoices.index')
            ->with('success', 'You have successfully submitted the selected invoice.');
    }
}
