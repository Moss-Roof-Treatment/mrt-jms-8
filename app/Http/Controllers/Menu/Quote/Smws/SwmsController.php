<?php

namespace App\Http\Controllers\Menu\Quote\Smws;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Swms;

class SwmsController extends Controller
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
        $all_swms = Swms::all();
        // Return the index view.
        return view('menu.quotes.swms.index')
            ->with('all_swms', $all_swms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.quotes.swms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'questions' => 'required',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required model instance.
        $selected_swms = Swms::findOrFail($id);
        // Return the show view.
        return view('menu.quotes.swms.show')
            ->with('selected_swms', $selected_swms);
    }
}
