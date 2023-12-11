<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\QuoteTask;

class TaskController extends Controller
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
        $selected_quote_task = QuoteTask::findOrFail($id);
        // Format the individual price from the request.
        $individual_price = preg_replace('/[$.,]/', '', $request->individual_price);
        // Update the selected model instance.
        $selected_quote_task->update([
            'individual_price' => $individual_price,
            'total_price' => $individual_price * $selected_quote_task->total_quantity,
            'description' => $request->description
        ]);
        // Update the tradepserson product total.
        $selected_quote_task->quote->updateQuoteProductTradespersonMaterials();
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected quote task');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd('here');

        // Find the required model instance.
        $selected_quote_task = QuoteTask::findOrFail($id);

        // WHY DID I DO IT THIS WAY ???????????
        // Find the related quote model instance, plick the id, cast to array, then implode the array to a variable.
        // $selected_quote_id = implode(Quote::find($selected_quote_task->quote_id)->pluck('id')->toArray());

        // Set the required quote id.
        $selected_quote_id = $selected_quote_task->quote_id;

        // Deleted the selected model instance.
        $selected_quote_task->delete();
        // Return a redirect to the quote show view.
        return redirect()
            ->route('quotes.show', $selected_quote_id)
            ->with('success', 'You have successfully deleted the selected quote task.');
    }
}
