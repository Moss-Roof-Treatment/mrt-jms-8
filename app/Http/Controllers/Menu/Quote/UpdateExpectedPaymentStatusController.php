<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;

class UpdateExpectedPaymentStatusController extends Controller
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
        // Find the required model instance.
        $selected_quote = Quote::findOrFail($id);
        // Update the selected model instance.
        $selected_quote->update([
            'expected_payment_method_id' => $request->expected_payment_method_id,
        ]);
        // Return redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected quote status.');
    }
}
