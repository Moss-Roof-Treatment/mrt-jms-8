<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Carbon\Carbon;

class FinaliseInvoiceController extends Controller
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
            'finalised_date' => $selected_invoice->finalised_date != null ? null : Carbon::now()
        ]);
        // Return redirect back with success message.
        return back()
            ->with('success', 'You have successfully updated the finalised status of the selected invoice.');
    }
}
