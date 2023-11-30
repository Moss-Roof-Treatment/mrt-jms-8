<?php

namespace App\Http\Controllers\Menu\Email\QuoteReminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\QuoteReminderResponse;
use App\Models\ReminderResponseStatus;

class ResetResponseController extends Controller
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
        // Validation.
        // Check if the request has the action.
        if (!isset($request->action)) {
            // The action value has not been set return a redirect back.
            return back()
                ->with('warning', 'No action was selected please try again.');
        }
        // Check which action was selected.
        switch ($request->action) {
            // Reset the quote response.
            case 'reset':
                // Validation.
                // Check if there is a quote reminder response that has the input quote id.
                $response = QuoteReminderResponse::where('quote_id', $id)->first();
                // Check if the variable is null.
                if ($response == null) {
                    // There is no response to delete.
                    // Return a redirect back.
                    return back()
                        ->with('warning', 'There is no quote reminder response to reset.');
                }
                // Find the required model instance.
                $selected_quote = Quote::findOrFail($id);
                // Delete the required model relationship instance.
                $selected_quote->quote_reminder_response->delete();
                // Update the selected quote.
                $selected_quote->update([
                    'is_sendable' => 1
                ]);
                // Return a redirect back.
                return back()
                    ->with('success', 'You have successfully reset the selected quote reminder response.');
            break;
            // Set the quote response as waiting.
            case 'waiting':
                // Find the required status.
                $selected_status = ReminderResponseStatus::find(2); // Waiting.
                // Create the new model instance.
                QuoteReminderResponse::create([
                    'quote_id' => $id,
                    'reminder_response_status_id' => $selected_status->id,
                    'response' => $selected_status->description
                ]);
                // Set the quote to not sendable.
                // Find the required quote.
                $selected_quote = Quote::find($id);
                // Update the selected quote.
                $selected_quote->update([
                    'is_sendable' => 0
                ]);
                // return a redirect back.
                return back()
                    ->with('success', 'You have successfully marked the selected quote reminder as waiting.');
            break;
        }
    }
}
