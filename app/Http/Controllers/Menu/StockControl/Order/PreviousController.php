<?php

namespace App\Http\Controllers\Menu\StockControl\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PreviousController extends Controller
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
        /*
        |--------------------------------------------------------------------------
        | Remove the required session variables.
        |--------------------------------------------------------------------------
        */

        $all_previous_orders = Order::where('postage_date', '!=', null) // Orders that have been posted.
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Remove the required session variables.
        |--------------------------------------------------------------------------
        */

        return view('menu.stockControl.orders.completed.index')
            ->with('all_previous_orders', $all_previous_orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Find the required model instance.
        |--------------------------------------------------------------------------
        */

        $selected_completed_order = Order::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Return the show view.
        |--------------------------------------------------------------------------
        */

        return view('menu.stockControl.orders.completed.show')
            ->with('selected_completed_order', $selected_completed_order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
