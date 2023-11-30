<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Event;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\Note;
use Auth;
use Carbon\Carbon;

class ProfileIconMenuComposer
{
    public function compose(View $view)
    {
        // JOBS ICON
        // Get all of the pending events that require a real date set.
        $current_jobs_count = Event::whereHas('quote.quote_users', fn ($q) => $q
        ->where('tradesperson_id', Auth::id())) // The authenticated user.
        ->whereHas('quote', fn ($q) => $q // Events that have a quote.
            ->where('finalised_date', '!=', null) // The finalised date has been set.
            ->where('completion_date', null) // Completion date has not been set.
        )->where('is_tradesperson_confirmed', 0) // The real work date has not been set.
        ->whereHas('job', fn ($q) => $q // Events that have a job.
            ->whereIn('job_status_id', [5,6]) // 5 - Sold (Deposit Paid), 6 - Sold (Payment On Completion).
        )
        ->count();

        // CALENDAR ICON
        // All user hosted events.
        $user_hosted_event_count = Event::where('staff_id', Auth::id())
            ->whereDate('start', '=', Carbon::today()->toDateString())
            ->count();
        // All user tradesperson events.
        $user_jobs_count = Event::whereHas('quote.quote_users', fn ($q) => $q
            ->where('tradesperson_id', Auth::id())) // The authenticated user.
            ->whereDate('start', '=', Carbon::today()->toDateString())
            ->count();
        // Return the count.
        $my_today_events = $user_hosted_event_count + $user_jobs_count;

        // NOTE ICON
        // All new notes where the auth user is the recipient.
        $new_notes_count = Note::where('recipient_id', Auth::id())
            ->where('recipient_seen_at', null)
            ->count();

        // INVOICE ICON
        // All outstanding invoices.
        $all_outstanding_invoices = Invoice::where('user_id', Auth::id())
            ->where('paid_date', null)
            ->count();

        // MESSAGES ICON
        // New messages sent to the auth user.
        $new_messages_count = Message::where('recipient_id', Auth::id())
            ->where('recipient_seen_at', null)
            ->count();

        // Add the data to the view.
        $view->with([
            'current_jobs_count' => $current_jobs_count,
            'my_today_events' => $my_today_events,
            'new_notes_count' => $new_notes_count,
            'all_outstanding_invoices' => $all_outstanding_invoices,
            'new_messages_count' => $new_messages_count
        ]);
    }
}