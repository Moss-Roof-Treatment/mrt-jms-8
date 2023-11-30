<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\QuoteRate;
use Carbon\Carbon;

class UpdateQuoteStatusController extends Controller
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
        $selected_quote = Quote::findOrFail($id);
        // Update the selected model instance.
        $selected_quote->update([
            'quote_status_id' => $request->quote_status_id,
        ]);
        // Update completed date if required.
        if (in_array($request->quote_status_id, [6,7])) { // 6 = completed, 7 = Paid.
            // Update the selected model instance.
            $selected_quote->update([
                'completion_date' => $selected_quote->completion_date == null ? Carbon::now() : $selected_quote->completion_date
            ]);
            // Garbage Collection.
            $selected_quote->garbageCollection();
        } elseif($request->quote_status_id == 8) { // Not Given.
            // Garbage Collection.
            $selected_quote->garbageCollection();
            // Find all job flags from this quote. 
            $selected_job_flags = QuoteRate::where('quote_id', $selected_quote->id)
                ->get();
            // Loop through each of the job flags.
            foreach($selected_job_flags as $flag) {
                // Update the selected job flag.
                $flag->update([
                    'staff_id' => null
                ]);
            }
        } elseif ($request->quote_status_id == 12) { // 12 = Payment Received.
            // Update the selected quote job status.
            $selected_quote->job->update([
                'job_status_id' => 12 // Set the job status to payment received by default. this saves doing it on both job and quote.
            ]);
            // Garbage Collection. ?????? prob not needed but just incase.
            $selected_quote->garbageCollection();
        }
        // Return redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected quote status.');
    }
}
