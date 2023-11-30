<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteStatus;

class QuoteStatusController extends Controller
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
        $quote_statuses = QuoteStatus::paginate(20);
        // Return the index view.
        return view('menu.settings.quoteStatus.index')
            ->with('quote_statuses', $quote_statuses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.quoteStatus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'title' => 'required|string|min:3|max:50|unique:quote_statuses,title',
            'description' => 'sometimes|nullable|string|min:10|max:500',
        ]);
        // Create a new model instance.
        QuoteStatus::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('quote-status-settings.index')
            ->with('success', 'You have successfully created a new quote status.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the required model instance.
        $selected_quote_status = QuoteStatus::findOrFail($id);
        // Return the show view.
        return view('menu.settings.quoteStatus.edit')
            ->with('selected_quote_status', $selected_quote_status);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate The Request Data.
        $request->validate([
            'title' => 'required|string|min:3|max:50|unique:quote_statuses,title,'.$id,
            'description' => 'sometimes|nullable|string|min:3|max:255',
        ]);
        // Find the required model instance.
        $selected_quote_status = QuoteStatus::findOrFail($id);
        // Update the selected model instance.
        $selected_quote_status->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('quote-status-settings.index')
            ->with('success', 'You have successfully updated the selected quote status.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required model instance.
        $selected_quote_status = QuoteStatus::findOrFail($id);
        // Delete the selected model instance.
        $selected_quote_status->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('quote-status-settings.index')
            ->with('success', 'You have successfully updated the selected quote status.');
    }
}
