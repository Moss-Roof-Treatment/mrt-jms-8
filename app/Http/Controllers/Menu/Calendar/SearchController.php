<?php

namespace App\Http\Controllers\Menu\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\QuoteUser;
use App\Models\User;

class SearchController extends Controller
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
        // Validation.
        // Check if the variable has been supplied.
        if (!isset($_GET['staff_id'])) {
            // The variable was not set.
            // Return a redirect back.
            return back()
                ->with('warning', 'Please select a user before click the search button.');
        }
        // Selected staff memeber.
        $selected_staff_member = User::findOrFail($_GET['staff_id']);
        // All staff users.
        $all_staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('login_status_id', 1) // 1 = Is Active.
            ->where('id', '!=', 1) // Not the first user in the database.
            ->with('account_role')
            ->get();
        // All quote ids from quote users.
        $selected_quote_ids = QuoteUser::where('tradesperson_id', $selected_staff_member->id)
            ->pluck('quote_id');
        // All events with the selected quote ids.
        $selected_quote_events = Event::whereIn('quote_id', $selected_quote_ids);
        // All events.
        $events = Event::where('staff_id', $selected_staff_member->id)
            ->union($selected_quote_events)
            ->orderBy('id','DESC')
            ->get();
        // Return the index view.
        return view('menu.calendar.search.index')
            ->with([
                'events' => $events,
                'selected_staff_member' => $selected_staff_member,
                'all_staff_members' => $all_staff_members
            ]);
    }
}
