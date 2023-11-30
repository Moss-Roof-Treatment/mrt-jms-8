<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoubleStoreySurcharge;

class DoubleStoreySurchargeController extends Controller
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
            'surcharge' => 'required|regex:/^[1-9][0-9]{0,2}(?:,?[0-9]{3}){0,3}\.[0-9]{2}$/', // Regex money input with no dollar sign.
        ]);
        // Find the required model instance.
        $selected_double_storey_surcharge = DoubleStoreySurcharge::findOrFail($id);
        // update the selected model instance.
        $selected_double_storey_surcharge->update([
            'price' => preg_replace('/[$.,]/', '', $request->surcharge) // Strip all dollar signs, commas and periods.
        ]);
        // Return the index view.
        return back()
            ->with('success', 'You have successfully updated the selected double storey surcharge.');
    }
}
