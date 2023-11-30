<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Event;
use App\Models\Quote;
use Carbon\Carbon;

class FinaliseQuoteController extends Controller
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
        // Create a log message.
        Log::info('404 - The selected user has navigated to the index route of a route resource that does not exist.');
        // Return abort 404.
        return abort(404);
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
        $selected_quote = Quote::find($id);
        // Update the selected model instance.
        // Set finalised date to carbon now.
        $selected_quote->update([
            'original_finalised_date' => $selected_quote->original_finalised_date == null
                ? Carbon::now()
                : $selected_quote->original_finalised_date,
            'finalised_date' => $selected_quote->finalised_date == null
                ? Carbon::now()
                : null
        ]);
        // Find the required event.
        $selected_event = Event::where('job_id', $selected_quote->job_id)
            ->first();
        // Check if the selected event collection is not empty.
        if ($selected_event != null) {
            // Update the selected event model instance.
            $selected_event->update([
                'title' => $selected_quote->job_id . ' ' . $selected_quote->job->tenant_suburb
            ]);
        }
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the editing status of the selected quote.');
    }
}
