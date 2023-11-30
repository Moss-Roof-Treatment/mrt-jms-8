<?php

namespace App\Http\Controllers\Menu\Quote\Filtered;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteStatus;

class FilterController extends Controller
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
    public function index(Request $request)
    {
        // All quote statuses.
        $all_quote_statuses = QuoteStatus::all('id', 'title');
        // Selected option.
        $selected_option = $request->quote_type_id;
        // Put selected quote status id into session.
        session(['filtered_quote_status_id' => $request->quote_type_id]);
        // Return the view.
        return view('menu.quotes.filtered.index')->with([
            'all_quote_statuses' => $all_quote_statuses,
            'selected_option' => $selected_option
        ]);
    }
}
