<?php

namespace App\Http\Controllers\Menu\StockControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class StockControlController extends Controller
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
        // Set The Required Variables.
        // Get the count of oders than have not been posted. 
        $pending_order_count = Order::where('postage_date', null)->count();
        // Return the index view.
        return view('menu.stockControl.index')
            ->with('pending_order_count', $pending_order_count);
    }
}
