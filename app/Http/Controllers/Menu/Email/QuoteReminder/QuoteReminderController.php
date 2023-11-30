<?php

namespace App\Http\Controllers\Menu\Email\QuoteReminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use Carbon\Carbon;

class QuoteReminderController extends Controller
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
        // The Timestamp at the end of the day two weeks ago.
        $timestamp = Carbon::now()->endOfDay()->subWeeks(2);

        // All non pending quotes.
        $all_quotes = Quote::whereIn('quote_status_id', [2]) // 2 = Pending.
            ->where('original_finalised_date', '<=', $timestamp)
            ->whereHas('customer', function ($q) { // With customers.
                return $q->where('email', '!=', null); // Customer email is not null.
            })
            ->with('quote_reminder_response')
            ->with('quote_reminder_response.reminder_response_status')
            ->with('customer')
            ->with('job')
            ->with('sent_quote_reminders')
            ->with('job.follow_up_call_status')
            ->get();

        // Return the index view.
        return view('menu.emails.quoteReminders.index')
            ->with('all_quotes', $all_quotes);
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
        $selected_quote->update([
            'is_sendable' => $selected_quote->is_sendable == 1 ? 0 : 1 
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully toggled the sendable status of the selected quote request.');
    }
}
