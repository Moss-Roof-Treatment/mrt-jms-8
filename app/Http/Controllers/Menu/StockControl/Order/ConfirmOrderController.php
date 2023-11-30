<?php

namespace App\Http\Controllers\Menu\StockControl\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use Carbon\Carbon;

class ConfirmOrderController extends Controller
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
        | Find the required model instance.
        |--------------------------------------------------------------------------
        */

        $selected_pending_order = Order::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Update the selected model instance.
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
        | Return the show view.
        |--------------------------------------------------------------------------
        */

        return view('menu.stockControl.orders.show')
            ->with('selected_pending_order', $selected_pending_order);
    }
}
