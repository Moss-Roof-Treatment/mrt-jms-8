<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Event;
use App\Models\Invoice;
use App\Models\Note;
use App\Models\Quote;
use App\Models\QuoteRequest;
use App\Models\SiteContact;
use Carbon\Carbon;

class IconMenuComposer
{
    public function compose(View $view)
    {
        // CALENDAR
        // Get all events on today.
        $event_count = Event::whereDate('start', '=', Carbon::today()->toDateString())
            ->count();
        // Unknow jobs (sold jobs without start date)
        $unknown_event_count = Event::whereHas('job', function ($q) {
            return $q->whereIn('job_status_id', [4,5,6]) // 4 = Deposit Pending, 5 = Deposit Paid, 6 = Deposit Pay on Completion.
                ->where('start_date', null);
        })->count();

        // INVOICES
        // Get the count of invoices that have not been paid.
        $pending_invoice_count = Invoice::where('paid_date', null)->count();

        // NOTES
        // New Notes
        $notes_count = Note::where('jms_acknowledged_at', null)
            ->count();
       // CUSTOMER NOTES COUNT
        // Customer sender notes.
        $customer_notes_count = Note::whereHas('sender', function ($q) {
                return $q->where('account_role_id', 5); // All Customers.
            })->where('jms_acknowledged_at', null)
            ->count();
        // SALESPERSON NOTES COUNT
        // Salesperson sender notes
        $salesperson_sender_notes_count = Note::whereHas('sender', function ($q) {
                return $q->whereIn('account_role_id', [2]); // Staff.
            })->where('jms_acknowledged_at', null)
            ->count();
        // Salesperson recipient notes
        $salesperson_recipient_notes_count = Note::whereHas('recipient', function ($q) {
                return $q->whereIn('account_role_id', [2]); // Staff.
            })->where('jms_acknowledged_at', null)
            ->count();
        // Sum sender and recipient notes.
        $salesperson_notes_count = $salesperson_sender_notes_count + $salesperson_recipient_notes_count;
        // TRADESPERSON NOTES COUNT
        // Tradesperson sender notes
        $tradesperson_sender_notes_count = Note::whereHas('sender', function ($q) {
                return $q->where('account_role_id', 3); // Tradesperson.
            })->where('jms_acknowledged_at', null)
            ->count();
        // Tradesperson recipient notes
        $tradesperson_recipient_notes_count = Note::whereHas('recipient', function ($q) {
                return $q->where('account_role_id', 3); // Tradesperson.
            })->where('jms_acknowledged_at', null)
            ->count();
        // Sum sender and recipient notes.
        $tradesperson_notes_count = $tradesperson_sender_notes_count + $tradesperson_recipient_notes_count;

        // QUOTE REQUESTS
        // All quote requests with a status that is not finished.
        $pending_quote_requests_count = QuoteRequest::where('quote_request_status_id', '!=', 3) // Finished.
            ->count();

        // EMAILS
        // Get the count of all quotes that have an email reminder that is not acknowledged.
        // Carbon timestamp of 2 weeks previous to now.
        $timestamp = Carbon::now()->subWeeks(2);
        // Find the quotes.
        $email_reminder_count = Quote::whereIn('quote_status_id', [2]) // 2 = Pending.
        ->where('finalised_date', '<=', $timestamp)
        ->whereHas('customer', function ($q) { // With customers.
            return $q->where('email', '!=', null); // Customer email is not null.
        })->whereHas('quote_reminder_response', function ($q) { // With customers.
            return $q->where('is_acknowledged', 0); // Customer email is not null.
        })->count();

        // Site contacts count
        $site_contacts_count = SiteContact::where('acknowledged_at', null) // Not acknowledged, new and seen.
            ->count();

        // Add the data to the view.
        $view->with([
            'event_count' => $event_count,
            'unknown_event_count' => $unknown_event_count,
            'pending_invoice_count' => $pending_invoice_count,
            'notes_count' => $notes_count,
            'customer_notes_count' => $customer_notes_count,
            'salesperson_notes_count' => $salesperson_notes_count,
            'site_contacts_count' => $site_contacts_count,
            'tradesperson_notes_count' => $tradesperson_notes_count,
            'pending_quote_requests_count' => $pending_quote_requests_count,
            'email_reminder_count' => $email_reminder_count
        ]);
    }
}