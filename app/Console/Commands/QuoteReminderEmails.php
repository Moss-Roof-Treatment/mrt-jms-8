<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use App\Mail\Customer\AutomaticQuoteReminder;
use App\Models\Note;
use App\Models\Quote;
use App\Models\SentQuoteReminder;
use Carbon\Carbon;

class QuoteReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all required quote reminder emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
        // Return true.
        return true;
    }
}
