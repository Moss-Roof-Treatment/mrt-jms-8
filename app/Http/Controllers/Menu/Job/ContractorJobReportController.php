<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobImage;
use App\Models\Quote;
use App\Models\QuoteTask;

class ContractorJobReportController extends Controller
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
        // Find the required model instance.
        $selected_quote = Quote::findOrFail($id);
        // Get PDF images.
        $all_pdf_images = JobImage::where('job_id', $selected_quote->job_id)
            ->where('is_pdf_image', 1) // Is pdf image.
            ->get();
        // Get all Quote Tasks.
        $all_quote_tasks = QuoteTask::where('quote_id', $selected_quote->id)
            ->orderBy('task_id', 'asc') // Ascending order.
            ->get();
        // Return the show view.
        return view('menu.jobs.contractorJobReport.show')
            ->with([
                'selected_quote' => $selected_quote,
                'all_pdf_images' => $all_pdf_images,
                'all_quote_tasks' => $all_quote_tasks
            ]);
    }
}
