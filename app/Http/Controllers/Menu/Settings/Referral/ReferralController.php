<?php

namespace App\Http\Controllers\Menu\Settings\Referral;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referral;

class ReferralController extends Controller
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
        return view('menu.settings.referrals.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.referrals.create');
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
            'title' => 'required|string|min:3|max:50|unique:referrals',
            'description' => 'sometimes|nullable|string|min:3|max:255',
        ]);
        // Create a new model instance.
        Referral::create([
            'title' => ucwords($request->title),
            'description' => ucfirst($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('referral-settings.index')
            ->with('success', 'You have successfully created a new referral.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the required model instance.
        $selected_referral = Referral::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.referrals.edit')
            ->with('selected_referral', $selected_referral);
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
        // Validate The Request Data.
        $request->validate([
            'title' => 'required|string|min:3|max:50|unique:referrals,title,'.$id,
            'description' => 'sometimes|nullable|string|min:3|max:255',
        ]);
        // Find the required model instance.
        $selected_referral = Referral::findOrFail($id);
        // Update the selected model instance.
        $selected_referral->update([
            'title' => ucwords($request->title),
            'description' => ucfirst($request->description)
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('referral-settings.index')
            ->with('success', 'You have successfully updated the selected referral.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required model instance.
        $selected_referral = Referral::findOrFail($id);
        // Delete the selected model instance.
        $selected_referral->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('referral-settings.index')
            ->with('success', 'You have successfully deleted the selected referral.');
    }
}
