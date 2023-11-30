<?php

namespace App\Http\Controllers\Menu\Settings\TermsAndConditions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsHeading;
use App\Models\TermsSubHeading;

class SubheadingController extends Controller
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
        $all_subheadings = TermsSubHeading::all();
        // return the index view.
        return view('menu.settings.termsAndConditions.subheadings.index')
            ->with('all_subheadings', $all_subheadings);
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
        $all_headings = TermsHeading::all();
        // return the create view.
        return view('menu.settings.termsAndConditions.subheadings.create')
            ->with('all_headings', $all_headings);
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
            'terms_heading_id' => 'required',
            'title' => 'required|string|min:3|max:100'
        ]);
        // Create a new model instance.
        TermsSubHeading::create([
            'terms_heading_id' => $request->terms_heading_id,
            'title' => ucwords($request->title)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-subheadings.index')
            ->with('success', 'You have successfully created a new terms and conditions subheading.');
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
        $selected_subheading = TermsSubHeading::find($id);
        // return the show view.
        return view('menu.settings.termsAndConditions.subheadings.show')
            ->with('selected_subheading', $selected_subheading);
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
        $selected_subheading = TermsSubHeading::find($id);
        // return the edit view.
        return view('menu.settings.termsAndConditions.subheadings.edit')
            ->with('selected_subheading', $selected_subheading);
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
            'title' => 'required|string|min:3|max:100'
        ]);
        // Find the required model instance.
        $selected_subheading = TermsSubHeading::find($id);
        // Update the selected model instance.
        $selected_subheading->update([
            'title' => ucwords($request->title)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-subheadings.index')
            ->with('success', 'You have successfully updated the selected terms and conditions subheading.');
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
        $selected_subheading = TermsSubHeading::find($id);
        // Delete the selected model instance.
        $selected_subheading->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-subheadings.index')
            ->with('success', 'You have successfully deleted the selected terms and conditions subheading.');
    }
}
