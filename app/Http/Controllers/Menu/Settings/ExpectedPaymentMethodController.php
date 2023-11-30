<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpectedPaymentMethod;

class ExpectedPaymentMethodController extends Controller
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
        $all_expected_payment_methods = ExpectedPaymentMethod::with('payment_method')
            ->with('payment_type')
            ->get();
        // Return the index view.
        return view('menu.settings.expectedPaymentMethods.index')
            ->with('all_expected_payment_methods', $all_expected_payment_methods);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
