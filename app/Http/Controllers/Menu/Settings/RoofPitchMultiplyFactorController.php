<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoofPitchMultiplyFactor;

class RoofPitchMultiplyFactorController extends Controller
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
        $all_roof_pitch_multiply_factors = RoofPitchMultiplyFactor::get();
        // Return the index view.
        return view('menu.settings.roofPitchFactor.index')
            ->with('all_roof_pitch_multiply_factors', $all_roof_pitch_multiply_factors);
    }
}
