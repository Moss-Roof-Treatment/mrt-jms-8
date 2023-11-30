<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\QuoteTask;
use App\Models\System;

class ViewWorkOrderController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Set The Required Variables.
        // Find the required quote.
        $selected_quote = Quote::findOrFail($id);
        // Find the required system.
        $system = System::firstOrFail(); // Moss Roof Treatment.
        // Get all Quote Tasks.
        $all_quote_tasks = QuoteTask::where('quote_id', $selected_quote->id)
            ->orderBy('task_id', 'asc') // Ascending order.
            ->get();
        // Return the show view.
        return view('menu.jobs.workOrder.show')
            ->with([
                'selected_quote' => $selected_quote,
                'system' => $system,
                'all_quote_tasks' => $all_quote_tasks
            ]);
    }
}
