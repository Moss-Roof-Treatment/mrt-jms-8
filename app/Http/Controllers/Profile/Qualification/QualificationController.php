<?php

namespace App\Http\Controllers\Profile\Qualification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Qualification;
use Auth;

class QualificationController extends Controller
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
        // Set The Required Variables.
        $selected_qualifications = Qualification::where('staff_id', Auth::id())
            ->get();
        // Return the index view
        return view('profile.qualifications.index')
            ->with('selected_qualifications', $selected_qualifications);
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
        $selected_qualification = Qualification::findOrFail($id);
        // Return the show view.
        return view('profile.qualifications.show')
            ->with('selected_qualification', $selected_qualification);
    }
}
