<?php

namespace App\Http\Controllers\Menu\StockControl\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use Carbon\Carbon;

class ConfirmPostageController extends Controller
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
        /*
        |--------------------------------------------------------------------------
        | Validate the request data.
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'courier_company_name' => 'required|string|min:3|max:80',
            'postage_confirmation_number' => 'required|string|min:3|max:50',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Find the required model instance.
        |--------------------------------------------------------------------------
        */

        $selected_pending_order = Order::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Validate the order confirmation status.
        |--------------------------------------------------------------------------
        */

        // Check if order has been confirmed.
        if ($selected_pending_order->confirmation_date == null) {

            // The order has not been confirmed so confirm it.
            $selected_pending_order->update([
                'staff_id' => Auth::id(),
                'confirmation_date' => Carbon::now()
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Update the selected model instance.
        |--------------------------------------------------------------------------
        */

        // Check if order has been posted.
        if ($selected_pending_order->postage_date == null) {

            // The order has not been posted so post it.
            $selected_pending_order->update([
                'courier_company_name' => $request->courier_company_name,
                'postage_confirmation_number' => $request->postage_confirmation_number,
                'postage_date' => Carbon::now()
            ]);

        } else {

            // The order has already been marked as posted, Return redirect with error message.
            return view('menu.stockControl.orders.show')
                ->with('selected_pending_order', $selected_pending_order)
                ->with('warning', 'The selected order has already been marked as posted to the customer.');
        }

        /*
        |--------------------------------------------------------------------------
        | Return the show view.
        |--------------------------------------------------------------------------
        */

        return view('menu.stockControl.orders.show')
            ->with('selected_pending_order', $selected_pending_order)
            ->with('success', 'You have successfully marked the selected order as posted to the customer.');
    }
}
