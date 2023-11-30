<?php

namespace App\Http\Controllers\Menu\Settings\TermsAndConditions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsItem;
use App\Models\TermsSubItem;

class SubitemController extends Controller
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
        $all_subitems = TermsSubItem::all();
        // return the index view.
        return view('menu.settings.termsAndConditions.subitems.index')
            ->with('all_subitems', $all_subitems);
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
        $all_items = TermsItem::all();
        // return the create view.
        return view('menu.settings.termsAndConditions.subitems.create')
            ->with('all_items', $all_items);
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
            'terms_item_id' => 'required',
            'text' => 'required|string|min:10|max:500'
        ]);
        // Create a new model instance.
        TermsSubItem::create([
            'terms_item_id' => $request->terms_item_id,
            'text' => ucwords($request->text)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-subitems.index')
            ->with('success', 'You have successfully created a new terms and conditions subitem.');
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
        $selected_subitem = TermsSubItem::find($id);
        // return the show view.
        return view('menu.settings.termsAndConditions.subitems.show')
            ->with('selected_subitem', $selected_subitem);
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
        $selected_subitem = TermsSubItem::find($id);
        // return the edit view.
        return view('menu.settings.termsAndConditions.subitems.edit')
            ->with('selected_subitem', $selected_subitem);
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
        $selected_subitem = TermsSubItem::find($id);
        // Update the selected model instance.
        $selected_subitem->update([
            'text' => ucwords($request->text)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-subitems.index')
            ->with('success', 'You have successfully updated the selected terms and conditions subitem.');
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
        $selected_subitem = TermsSubItem::find($id);
        // Delete the selected model instance.
        $selected_subitem->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-subitems.index')
            ->with('success', 'You have successfully deleted the selected terms and conditions subitem.');
    }
}
