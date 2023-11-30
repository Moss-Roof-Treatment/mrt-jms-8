<?php

namespace App\Http\Controllers\Menu\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Carbon\Carbon;

class StaffConfirmationController extends Controller
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
        $selected_invoice = Invoice::findOrFail($id);
        // Check if the finalised date is not null.
        if ($selected_invoice->confirmed_date != null) {
            // Set the finalised date as null.
            $selected_invoice->update([
                'confirmed_date' => null
            ]);
        } else {
            // Set the finalised date to now.
            $selected_invoice->update([
                'confirmed_date' => Carbon::now(),
                'finalised_date' => $selected_invoice->finalised_date == null ? Carbon::now() : $selected_invoice->finalised_date,
                'submission_date' => $selected_invoice->submission_date == null ? Carbon::now() : $selected_invoice->submission_date
            ]);
        }
        // Return the redirect back.
        return back()
            ->with('succes', 'You have successfully updated the confirmation status of the selected invoice.');
    }
}
