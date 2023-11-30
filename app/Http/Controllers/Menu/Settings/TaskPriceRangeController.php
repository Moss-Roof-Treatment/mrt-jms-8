<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskPriceRange;
use App\Models\DoubleStoreySurcharge;

class TaskPriceRangeController extends Controller
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
        $all_task_price_range = TaskPriceRange::all();
        // Set The Required Variables.
        $double_storey_surcharge = DoubleStoreySurcharge::first();
        // Return the index view.
        return view('menu.settings.taskPriceRanges.index')
            ->with([
                'all_task_price_range' => $all_task_price_range,
                'double_storey_surcharge' => $double_storey_surcharge
            ]);
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
        $selected_task_ranges = TaskPriceRange::findOrFail($id);
        // update the selected model instance.
        $selected_task_ranges->update([
            'price' => preg_replace('/[$.,]/', '', $request->price)
        ]);
        // Return the index view.
        return back()
            ->with('success', 'You have successfully updated the selected task range');
    }
}
