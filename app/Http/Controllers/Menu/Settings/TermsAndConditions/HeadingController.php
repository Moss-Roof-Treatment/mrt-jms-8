<?php

namespace App\Http\Controllers\Menu\Settings\TermsAndConditions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsHeading;

class HeadingController extends Controller
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
        $all_headings = TermsHeading::all();
        // return the index view.
        return view('menu.settings.termsAndConditions.headings.index')
            ->with('all_headings', $all_headings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return the create view.
        return view('menu.settings.termsAndConditions.headings.create');
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
            'title' => 'required|string|min:3|max:100'
        ]);
        // Create a new model instance.
        TermsHeading::create([
            'title' => ucwords($request->title)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-headings.index')
            ->with('success', 'You have successfully created a new terms and conditions heading.');
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
        $selected_heading = TermsHeading::find($id);
        // return the show view.
        return view('menu.settings.termsAndConditions.headings.show')
            ->with('selected_heading', $selected_heading);
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
        $selected_heading = TermsHeading::find($id);
        // return the edit view.
        return view('menu.settings.termsAndConditions.headings.edit')
            ->with('selected_heading', $selected_heading);
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
        $selected_heading = TermsHeading::find($id);
        // Update the selected model instance.
        $selected_heading->update([
            'title' => ucwords($request->title)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-headings.index')
            ->with('success', 'You have successfully updated the selected terms and conditions heading.');
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
        $selected_heading = TermsHeading::find($id);
        // Delete the selected model instance.
        $selected_heading->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('terms-and-conditions-headings.index')
            ->with('success', 'You have successfully deleted the selected terms and conditions heading.');
    }
}
