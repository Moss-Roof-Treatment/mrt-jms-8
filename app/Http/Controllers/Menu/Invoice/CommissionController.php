<?php

namespace App\Http\Controllers\Menu\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteCommission;
class CommissionController extends Controller
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
        // Find all commissions.
        $all_commissions = QuoteCommission::all();
        // Return the index view.
        return view('menu.invoices.commissions.index')
            ->with('all_commissions', $all_commissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required commission.
        $selected_commission = QuoteCommission::find($id);
        // Return the show view.
        return view('menu.invoices.commissions.show')
            ->with('selected_commission', $selected_commission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the required commission.
        $selected_commission = QuoteCommission::find($id);
        // Return the edit view.
        return view('menu.invoices.commissions.edit')
            ->with('selected_commission', $selected_commission);
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
        // Find the required commission.
        $selected_commission = QuoteCommission::find($id);
        // Set the required variables.
        $edited_total = isset($request->edited_total)
            ? preg_replace('/[$.,]/', '', $request->edited_total)
            : 0;
        // Update the selected commission.
        $selected_commission->update([
            'edited_total' => $edited_total
        ]);
        // Return a redirect to the show view.
        return redirect()
            ->route('invoice-commissions.show', $id)
            ->with('success', 'You have successfully updated the selected commission.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required commission.
        $selected_commission = QuoteCommission::find($id);
        // Set the required variables.
        $selected_commission->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('invoice-commissions.index')
            ->with('success', 'You have successfully deleted the selected commission.');
    }
}
