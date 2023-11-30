<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class DiscountCodeController extends Controller
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
        $discount_codes = Coupon::paginate(20);
        // Return the index view.
        return view('menu.settings.discountCodes.index')
            ->with('discount_codes', $discount_codes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.discountCodes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Pre-validation sanitisation.
        // Value filter.
        if (isset($request->value)) {
            // Remove period if it is entered.
            $request->value = str_replace('.', '', $request->value);
        }

        // Percentage off filter.
        if (isset($request->percent_off)) {
            // Remove percentage sign if it is entered.
            $request->percent_off = str_replace('%', '', $request->percent_off);
        }

        // Validate The Request Data.
        $request->validate([
            'code' => 'required|string|min:3|max:50|unique:coupons,code',
            'value' => 'sometimes|nullable|numeric|min:1|max:999',
            'percent_off' => 'sometimes|nullable|integer|min:1|max:100',
            'description' => 'sometimes|nullable|string|min:5|max:255',
        ]);

        // Set The Required Variables.
        // Check for value entered to set type.
        if (isset($request->value)) {

            // Set selected type as fixed value.
            $selected_type = "fixed";
        }

        // Check for value entered to set type.
        if (isset($request->percent_off)) {

            // Set selected type as percent off.
            $selected_type = "percent";
        }

        // Create a new model instance.
        $new_discount_code = new Coupon;

        $new_discount_code->code = $request->code;
        $new_discount_code->type = $selected_type;
        $new_discount_code->value = $request->value;
        $new_discount_code->percent_off = $request->percent_off;
        $new_discount_code->description = ucfirst($request->description);

        // Is active radio button.
        if ($request->is_active == 1) {
            $new_discount_code->is_active = 1;
        } else {
            $new_discount_code->is_active = 0;
        }

        $new_discount_code->save();

        // Return a redirect to the index route.
        return redirect()
            ->route('discount-code-settings.index')
            ->with('success', 'You have successfully created a new discount code.');
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
        $selected_discount_code = Coupon::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.discountCodes.edit')
            ->with('selected_discount_code', $selected_discount_code);
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
        // Pre-validation sanitisation.
        // Value filter.
        if (isset($request->value)) {
            // Remove period if it is entered.
            $request->value = str_replace('.', '', $request->value);
        }

        // Percentage off filter.
        if (isset($request->percent_off)) {
            // Remove percentage sign if it is entered.
            $request->percent_off = str_replace('%', '', $request->percent_off);
        }

        // Validate The Request Data.
        $request->validate([
            'code' => 'required|string|min:3|max:50|unique:coupons,code,'.$id,
            'value' => 'sometimes|nullable|numeric|min:1|max:999',
            'percent_off' => 'sometimes|nullable|integer|min:1|max:100',
            'description' => 'sometimes|nullable|string|min:5|max:255',
        ]);

        // Find the required model instance.
        $selected_discount_code = Coupon::findOrFail($id);

        // Update the selected model instance.
        $selected_discount_code->code = $request->code;
        $selected_discount_code->value = $request->value;
        $selected_discount_code->percent_off = $request->percent_off;
        $selected_discount_code->description = ucfirst($request->description);

        // Is active radio button.
        if ($request->is_active == 1) {
            $selected_discount_code->is_active = 1;
        } else {
            $selected_discount_code->is_active = 0;
        }

        $selected_discount_code->save();

        // Return a redirect to the show route.
        return redirect()
            ->route('discount-code-settings.index')
            ->with('success', 'You have successfully updated the selected discount code.');
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
        $selected_discount_code = Coupon::findOrFail($id);
        // Delete the selected model instance.
        $selected_discount_code->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('discount-code-settings.index')
            ->with('success', 'You have successfully deleted the selected discount code.');
    }
}
