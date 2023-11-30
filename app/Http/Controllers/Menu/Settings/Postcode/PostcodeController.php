<?php

namespace App\Http\Controllers\Menu\Settings\Postcode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Postcode;

class PostcodeController extends Controller
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
        // Return the index view.
        return view('menu.settings.postcodes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.postcodes.create');
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
            'title' => 'required|string|min:3|max:80',
            'code' => 'required|digits:4|unique:postcodes',
        ]);
        // Create a new model instance.
        Postcode::create([
            'title' => ucwords($request->title),
            'code' => $request->code
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('postcode-settings.index')
            ->with('success', 'You have successfully created a new postcode.');
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
        $selected_postcode = Postcode::findOrFail($id);
        // Return the show view.
        return view('menu.settings.postcodes.edit')
            ->with('selected_postcode', $selected_postcode);
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
            'title' => 'required|string|min:3|max:50|unique:postcodes,title,'.$id,
            'resolution_amount' => 'required',
            'resolution_period' => 'required',
            'colour' => 'required',
        ]);
        // Find the required model instance.
        $selected_postcode = Postcode::findOrFail($id);
        // Update the selected model instance.
        $selected_postcode->update([
            'title' => ucwords($request->title),
            'code' => $request->code
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('postcode-settings.index')
            ->with('success', 'You have successfully updated the selected postcode.');
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
        $selected_postcode = Postcode::findOrFail($id);
        // Delete the selected model instance.
        $selected_postcode->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('postcode-settings.index')
            ->with('success', 'You have successfully updated the selected postcode.');
    }
}
