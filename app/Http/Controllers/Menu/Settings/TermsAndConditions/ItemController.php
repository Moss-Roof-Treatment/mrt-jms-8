<?php

namespace App\Http\Controllers\Menu\Settings\TermsAndConditions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsItem;
use App\Models\TermsSubHeading;

class ItemController extends Controller
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
        // Find all the required model instances.
        $all_items = TermsItem::all();
        // return the index view.
        return view('menu.settings.termsAndConditions.items.index')
            ->with('all_items', $all_items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // All headings.
        $all_subheadings = TermsSubHeading::all();
        // return the create view.
        return view('menu.settings.termsAndConditions.items.create')
            ->with('all_subheadings', $all_subheadings);
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
            'terms_sub_heading_id' => 'required',
            'text' => 'required|string|min:10|max:500'
        ]);
        // Create a new model instance.
        TermsItem::create([
            'terms_sub_heading_id' => $request->terms_sub_heading_id,
            'text' => ucwords($request->text)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-items.index')
            ->with('success', 'You have successfully created a new terms and conditions item.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required model instance.
        $selected_item = TermsItem::find($id);
        // return the show view.
        return view('menu.settings.termsAndConditions.items.show')
            ->with('selected_item', $selected_item);
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
        $selected_item = TermsItem::find($id);
        // return the edit view.
        return view('menu.settings.termsAndConditions.items.edit')
            ->with('selected_item', $selected_item);
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
            'text' => 'required|string|min:10|max:500'
        ]);
        // Find the required model instance.
        $selected_item = TermsItem::find($id);
        // Update the selected model instance.
        $selected_item->update([
            'text' => ucwords($request->text)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-items.index')
            ->with('success', 'You have successfully updated the selected terms and conditions item.');
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
        $selected_item = TermsItem::find($id);
        // Delete the selected model instance.
        $selected_item->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-items.index')
            ->with('success', 'You have successfully deleted the selected terms and conditions item.');
    }
}
