<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\System;

class MenuController extends Controller
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
        //
        // INVOICE FIXES.
        //
        // $all_invoices = Invoice::all();
        // // Loop through each invoice.
        // foreach($all_invoices as $invoice) {
        //     // Calculate the invoice feilds.
        //     $invoice->calculateInvoiceTotals();
        // }

        // Get the systems variables.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Return the index view.
        return view('menu.index', [
            'selected_system' => $selected_system
        ]);
    }
}