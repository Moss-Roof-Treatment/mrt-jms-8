<?php

namespace App\Http\Controllers\Menu\Tradesperson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rate;
use App\Models\RateUser;
use App\Models\User;

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
        // Validation.
        // Check if the variable has been supplied.
        if (!isset($_GET['selected_user_id'])) {
            // The variable was not set.
            // Return a redirect back.
            return back()
                ->with('warning', 'The required resource could not be found.');
        }
        // Set The Required Variables.
        // Find the required user.
        $selected_user = User::find($_GET['selected_user_id']);
        // Get all rate user relationships.
        $selected_rates = RateUser::where('user_id', $selected_user->id)
            ->get();
        // Return the index view.
        return view('menu.tradespersons.rates.index', [
            'selected_user' => $selected_user,
            'selected_rates' => $selected_rates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Validation.
        // Check if the variable has been supplied.
        if (!isset($_GET['selected_user_id'])) {
            // The variable was not set.
            // Return a redirect back.
            return back()
                ->with('warning', 'The required resource could not be found.');
        }
        // Set The Required Variables.
        // Find the required user.
        $selected_user = User::find($_GET['selected_user_id']);
        // Get all rates.
        $all_rates = Rate::all();
        // Return the create view.
        return view('menu.tradespersons.rates.create', [
            'selected_user' => $selected_user,
            'all_rates' => $all_rates
        ]);
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
            'rate_id' => 'required',
            'price' => 'required|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
        ]);
        // Create the new model instance.
        $new_rate = RateUser::create([
            'rate_id' => $request->rate_id,
            'user_id' => $request->user_id,
            'price' => preg_replace('/[$.,]/', '', $request->price) // Strip all dollar signs, commas and periods.
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('tradesperson-rates.index', $new_rate->id)
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
        $selected_rate = RateUser::findOrFail($id);
        // Return the show view.
        return view('menu.tradespersons.rates.show')
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
        $selected_rate = RateUser::findOrFail($id);
        // Return the show view.
        return view('menu.tradespersons.rates.edit')
            ->with('selected_rate', $selected_rate);
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
            'price' => 'required|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
        ]);
        // Find the required model instance.
        $selected_rate = RateUser::findOrFail($id);
        // Update the selected model instance.
        $selected_rate->update([
            'price' => preg_replace('/[$.,]/', '', $request->price) // Strip all dollar signs, commas and periods.
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('tradesperson-rates.show', $selected_rate->id)
            ->with('success', 'You have successfully updated the selected tradesperson rate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Find the required model instance.
        $selected_rate = RateUser::findOrFail($id);
        // Delete the selected model instance.
        $selected_rate->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('tradesperson-rates.index', ['selected_user_id' => $request->selected_user_id])
            ->with('success', 'You have successfully deleted the selected tradesperson rate.');
    }
}
