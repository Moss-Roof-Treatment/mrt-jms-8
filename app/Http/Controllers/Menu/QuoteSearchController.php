<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;

class QuoteSearchController extends Controller
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
        // Validate The Request Data.
        $request->validate([
            'quote_id' => 'required|min:1|max:8'
        ]);
        // Find the required model instance.
        $selected_quote = Quote::find($request->quote_id);
        // Check if quote has been found.
        if (!isset($selected_quote)) {
            // No quote was found.
            // Search by quote identifier.
            $selected_quote = Quote::where('quote_identifier', $request->quote_id)
                ->first();
        }
        // Check if quote has been found.
        if (!isset($selected_quote)) {
            // Quote does not exist.
            // Return a redirect back.
            return back()
                ->with('warning', 'There is no quote that matches the quote number that you have entered.');
        } else {
            // Quote exists.
            // Return a redirect to the quote show view.
            return redirect()
                ->route('quotes.show', $selected_quote->id);
        }
    }
}
