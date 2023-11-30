<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Event;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\Note;
use App\Models\Order;
use App\Models\QuoteRequest;
use App\Models\SiteContact;
use Carbon\Carbon;

class MainMenuComposer
{
    public function compose(View $view)
    {
        // CALENDAR
        // Get all events on today.
        $event_count = Event::whereDate('start', '=', Carbon::today()->toDateString())
            ->count();

        // INVOICES
        // Get the count of invoices that have not been paid.
        $pending_invoice_count = Invoice::where('paid_date', null)->count();

        // MESSAGES
        // Get the count of messages than have not been seen by the JMS.
        $new_message_count = Message::where('jms_seen_at', null)->count();

        // NOTES
        // New Notes
        $notes_count = Note::where('jms_acknowledged_at', null)
            ->count();
        // Customer Sent Notes
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

        // Tradesperson Sent Note
        $tradesperson_notes_count = Note::whereHas('sender', function ($q) {
                return $q->where('account_role_id', 3); // Tradesperson.
            })->where('jms_acknowledged_at', null)
            ->count();

        // QUOTE REQUESTS
        // All quote requests with a status that is not finished.
        $pending_quote_requests_count = QuoteRequest::where('quote_request_status_id', '!=', 3) // Finished.
            ->count();

        // STOCK CONTROL
        // Get the count of oders than have not been posted. 
        $pending_order_count = Order::where('postage_date', null)->count();

        // SITE CONTACTS
        // All pending site contacts.
        $pending_site_contact_count = SiteContact::where('acknowledged_at', null)
            ->count();

        // Add the data to the view.
        $view->with([
            'event_count' => $event_count,
            'pending_invoice_count' => $pending_invoice_count,
            'new_message_count' => $new_message_count,
            'notes_count' => $notes_count,
            'customer_notes_count' => $customer_notes_count,
            'salesperson_notes_count' => $salesperson_notes_count,
            'tradesperson_notes_count' => $tradesperson_notes_count,
            'pending_quote_requests_count' => $pending_quote_requests_count,
            'pending_order_count' => $pending_order_count,
            'pending_site_contact_count' => $pending_site_contact_count,
        ]);
    }
}