<?php

namespace App\Http\Controllers\Menu\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailController extends Controller
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
        return view('menu.emails.index');
    }
}
