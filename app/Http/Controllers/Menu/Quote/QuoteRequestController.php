<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\QuoteRequest;

class QuoteRequestController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Find all the required model instances.
        $all_quote_requests = QuoteRequest::whereIn('quote_request_status_id', [1,2]) // 1 = New, Pending = 2.
            ->get();
        // Return the index view.
        return view('menu.quotes.requests.index')
            ->with('all_quote_requests', $all_quote_requests);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required model instance.
        $selected_quote_request = QuoteRequest::findOrFail($id);
        // Check if the quote request status is not set to completed.
        if ($selected_quote_request->quote_request_status_id != 3) { // Is not completed.
            // Update the selected model instance.
            $selected_quote_request->update([
                'quote_request_status_id' => 2, // Pending.
            ]);
        }
        // Return the show view.
        return view('menu.quotes.requests.show')
            ->with('selected_quote_request', $selected_quote_request);
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
        $selected_quote_request = QuoteRequest::findOrFail($id);
        // Secondary validation.
        if ($selected_quote_request->is_editable == 0) { // Not Editable.
            // Return redirect back.
            return back()
                ->with('warning', 'The selected quote request cannot be edited as it has already been converted to a quote.');
        }
        // Update the selected model instance.
        $selected_quote_request->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected quote request.');
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
        $selected_quote_request = QuoteRequest::findOrFail($id);
        // Secondary validation.
        if ($selected_quote_request->is_delible == 0) { // Not Delible.
            // Return redirect back.
            return back()
                ->with('warning', 'The selected quote request cannot be deleted as it has already been converted to a quote.');
        }

        // Check if the related job has already been created.
        if ($selected_quote_request->job_id != null) {
            // Find the required event.
            $selected_event = Event::where('job_id', $selected_quote_request->job_id)
                ->first();
            // Check if the required event exists.
            if ($selected_event != null) {
                // Delete the selected event.
                $selected_event->delete();
            }
        }
        // Delete the selected model instance.
        $selected_quote_request->delete();
        // Return a redirect to the quote request index route.
        return redirect()
            ->route('quote-requests.index')
            ->with('success', 'You have successfully deleted the selected quote request.');
    }
}
