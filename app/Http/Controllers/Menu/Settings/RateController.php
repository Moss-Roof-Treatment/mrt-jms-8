<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rate;

class RateController extends Controller
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
        $all_rates = Rate::all();
        // Return the index view.
        return view('menu.settings.rates.index')
            ->with('all_rates', $all_rates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.rates.create');
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
            'title' => 'required|string|min:10|max:100|unique:rates,title',
            'price' => 'required|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
            'description' => 'required|string|min:10|max:1000',
            'procedure' => 'required|string|min:10|max:1000',
        ]);
        // Create the new model instance.
        $new_rate = Rate::create([
            'title' => ucwords($request->title),
            'procedure' => $request->procedure,
            'description' => $request->description,
            'price' => preg_replace('/[$.,]/', '', $request->price), // Strip all dollar signs, commas and periods.
            'is_selectable' => $request->is_selectable == 1 ? 1 : 0,
            'is_editable' => $request->is_editable == 1 ? 1 : 0,
            'is_delible' => $request->is_delible == 1 ? 1 : 0,
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('rate-settings.show', $new_rate->id)
            ->with('success', 'You have successfully created a new tradesperson rate.');
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
        $selected_rate = Rate::with('rate_users')
            ->with('rate_users.user')
            ->with('rate_users.user.account_class')
            ->findOrFail($id);
        // Return the show view.
        return view('menu.settings.rates.show')
            ->with('selected_rate', $selected_rate);
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
        $selected_rate = Rate::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.rates.edit')
            ->with(['selected_rate' => $selected_rate]);
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
            'title' => 'required|string|min:10|max:100|unique:rates,title,'.$id,
            'price' => 'required|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
            'description' => 'required|string|min:10|max:1000',
            'procedure' => 'required|string|min:10|max:1000',
        ]);
        // Find the required model instance.
        $selected_rate = Rate::findOrFail($id);
        // Update the selected model instance.
        $selected_rate->update([
            'title' => ucwords($request->title),
            'procedure' => $request->procedure,
            'description' => $request->description,
            'price' => preg_replace('/[$.,]/', '', $request->price), // Strip all dollar signs, commas and periods.
            'is_selectable' => $request->is_selectable == 1 ? 1 : 0,
            'is_editable' => $request->is_editable == 1 ? 1 : 0,
            'is_delible' => $request->is_delible == 1 ? 1 : 0,
        ]);
        // Return redirect to the show page.
        return redirect()
            ->route('rate-settings.show', $selected_rate->id)
            ->with('success', 'You have successfully edited the selected tradesperson rate.');
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
        $selected_rate = Rate::findOrFail($id);
        // Check delible status.
        if ($selected_rate->is_delible == 0) {
            // item is not delible.
            // return a redirect back with message.
            return back()
                ->with('danger', 'This item is not delible as it is in use.');
        }
        // Delete the selected model instance.
        $selected_rate->delete();
        // Return redirect to the index page.
        return redirect()
            ->route('rate-settings.index')
            ->with('success', 'You have successfully deleted the selected tradesperson rate.');
    }
}
