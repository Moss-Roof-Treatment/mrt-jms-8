<?php

namespace App\Http\Controllers\Profile\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class FinancialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAnyStaffMember');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Find the required model instance.
        $selected_user = User::find(Auth::id());
        // Return the index view
        return view('profile.financials.index')
            ->with('selected_user', $selected_user);
    }
}
