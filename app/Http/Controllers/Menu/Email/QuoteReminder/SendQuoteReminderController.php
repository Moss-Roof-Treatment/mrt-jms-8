<?php

namespace App\Http\Controllers\Menu\Email\QuoteReminder;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use App\Mail\Customer\AutomaticQuoteReminder;
use App\Models\Note;
use App\Models\Quote;
use App\Models\SentQuoteReminder;
use Carbon\Carbon;

class SendQuoteReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Set The Required Variables.
        // Carbon timestamp of 2 weeks previous to now.
        $timestamp = Carbon::now()->subWeeks(2);
        // All required quotes.
        $selected_quotes = Quote::whereIn('quote_status_id', [2]) // 2 = Pending.
            ->where('is_sendable', 1) // 1 = is sendable.
            ->where('finalised_date', '<=', $timestamp)
            ->whereHas('customer', fn ($q) => $q->where('email', '!=', null)) // Customer with not null email.
            ->with('customer')
            ->get();
        // Send the required emails.
        // Loop through each selected quote.
        foreach($selected_quotes as $quote) {
            // Make the data variable.
            $data = [
                'recipient_name' => $quote->customer->getFullNameAttribute(),
                'selected_quote_id' => $quote->id
            ];
            // Send the email.
            Mail::to($quote->customer->email)
                ->send(new AutomaticQuoteReminder($data));
            // Create the note.
            Note::create([
                'job_id' => $quote->job_id,
                'text' => '"Automatic Quote Reminder" email sent to customer for quote: ' . $quote->quote_identifier,
                'is_internal' => 1,
                'jms_seen_at' => Carbon::now(),
                'jms_acknowledged_at' => Carbon::now(),
            ]);
            // Create the sent timestamp.
            SentQuoteReminder::create([
                'quote_id' => $quote->id
            ]);
        }
        // Return redirect back with success message.
        return back()
            ->with('success', 'You have successfully send the quote reminder emails.');
    }
}
