<?php

namespace App\Http\Controllers\Menu\StockControl\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PendingController extends Controller
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
        | Find all of the required model instances.
        |--------------------------------------------------------------------------
        */

        $all_pending_orders = Order::where('postage_date', null) // Orders that have not been posted.
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return the index view.
        |--------------------------------------------------------------------------
        */

        return view('menu.stockControl.orders.index')
            ->with('all_pending_orders', $all_pending_orders);
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

        $selected_pending_order = Order::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Return the show view.
        |--------------------------------------------------------------------------
        */

        return view('menu.stockControl.orders.show')
            ->with('selected_pending_order', $selected_pending_order);
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
