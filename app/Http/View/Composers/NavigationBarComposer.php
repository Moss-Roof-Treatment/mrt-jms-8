<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Message;
use App\Models\Note;
use Auth;

class NavigationBarComposer
{
    public function compose(View $view)
    {
        // NOTES COUNT
        // All new notes where the auth user is the recipient.
        $new_notes_count = Note::where('recipient_id', Auth::id())
            ->where('recipient_seen_at', null)
            ->count();

        // MESSAGES COUNT
        // New messages sent to the auth user.
        $all_new_sent_messages_count = Message::where('recipient_id', Auth::id())
            ->where('recipient_seen_at', null)
            ->count();

        // ALL ITEMS COUNT
        $notification_count = $new_notes_count + $all_new_sent_messages_count;

        // Add the data to the view.
        $view->with('notification_count', $notification_count);
    }
}