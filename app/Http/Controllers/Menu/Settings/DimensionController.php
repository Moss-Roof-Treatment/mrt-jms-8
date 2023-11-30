<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dimension;

class DimensionController extends Controller
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
        $dimensions = Dimension::paginate(20);
        // Return the index view.
        return view('menu.settings.dimensions.index')
            ->with('dimensions', $dimensions);
    }
}
