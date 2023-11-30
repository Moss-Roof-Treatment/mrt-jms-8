<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteRequestStatus;

class QuoteRequestStatusController extends Controller
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
        // Find all of the required model instances.
        $all_quote_rrequest_statuses = QuoteRequestStatus::all();
        // Return the index view.
        return view('menu.settings.quoteRequests.index')
            ->with('all_quote_rrequest_statuses', $all_quote_rrequest_statuses);
    }
}
