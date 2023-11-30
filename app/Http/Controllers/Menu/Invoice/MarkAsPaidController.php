<?php

namespace App\Http\Controllers\Menu\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Auth;
use Carbon\Carbon;

class MarkAsPaidController extends Controller
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
            'confirmation_number' => 'required|unique:invoices,confirmation_number',
            'confirmation_date' => 'required',
        ]);
        // Find the required model instance.
        $selected_invoice = Invoice::findOrFail($id);
        // Update the selected model instance.
        $selected_invoice->update([
            'finalised_date' => $selected_invoice->finalised_date == null ? Carbon::now() : $selected_invoice->finalised_date,
            'submission_date' => $selected_invoice->submission_date == null ? Carbon::now() : $selected_invoice->submission_date,
            'confirmed_date' => Carbon::parse($request->confirmation_date)->startOfDay(),
            'paid_date' => Carbon::parse($request->confirmation_date)->startOfDay(),
            'confirmation_number' => $request->confirmation_number,
            'staff_id' => Auth::id()
        ]);
        // Return redirect back.
        return back()
            ->with('success', 'You have successfully marked the selected invoice as paid.');
    }
}
