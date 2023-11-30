<?php

namespace App\Http\Controllers\Menu\Settings\RoundingCalculator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalculatorController extends Controller
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
        // Return the index view.
        return view('menu.settings.roundingCalculator.index');
    }
}
