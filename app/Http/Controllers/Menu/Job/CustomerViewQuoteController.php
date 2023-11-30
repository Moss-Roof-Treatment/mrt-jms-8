<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobImage;
use App\Models\JobImageQuote;
use App\Models\Quote;
use App\Models\QuoteTask;
use App\Models\System;
use PDF;

class CustomerViewQuoteController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Find the required quote.
        $selected_quote = Quote::findOrFail($_GET['quote_id']);
        // Find the required system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // GET ALL REQUIRED QUOTE IMAGES
        // Get all required job image quote model instances.
        $all_pdf_images = JobImageQuote::where('quote_id', $selected_quote->id)
            ->get();
        // Check if the $all_pdf_images variable is empty.
        if ($all_pdf_images->isEmpty()){
            // Use job images.
            // Get all the required job images.
            $all_pdf_images = JobImage::where('job_id', $selected_quote->job_id)
                ->where('is_pdf_image', 1) // Is pdf image.
                ->get();
        } else {
            // Use quote images.
            // Pluck ids.
            $image_array = $all_pdf_images->pluck('job_image_id')->toArray();
            // Get all the required job images.
            $all_pdf_images = JobImage::find($image_array);
        }
        // Get all Quote Tasks.
        $all_quote_tasks = QuoteTask::where('quote_id', $selected_quote->id)
            ->whereHas('task', function ($q) {
                return $q->where('is_quote_visible', 1); // Is visible on quote.
            })
            ->orderBy('task_id', 'asc') // Ascending order.
            ->get();
        // Create the footer object.
        $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';
        // Generate PDF.
        $pdf = PDF::loadView('menu.jobs.customerViewQuote.pdf.create', compact('selected_system', 'selected_quote', 'all_pdf_images', 'all_quote_tasks'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait')
            ->setOption('footer-html', $footer);
        // Make Quote Title variable.
        if ($selected_quote->finalised_date == null) {
            // The quote is not finalised yet, no finalised date in the name.
            $pdf_title = $selected_system->acronym . '-quote.pdf';
        } else {
            // The quote is finalised, show the finalised date in the name.
            $pdf_title = $selected_system->acronym . '-' . date('d-m-y', strtotime($selected_quote->finalised_date)) . '-quote.pdf';
        }
        // Download as pdf.
        return $pdf->download($pdf_title);
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
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // GET ALL REQUIRED QUOTE IMAGES
        // Get all required job image quote model instances.
        $all_pdf_images = JobImageQuote::where('quote_id', $id)
            ->get();
        // Check if the $all_pdf_images variable is empty.
        if ($all_pdf_images->isEmpty()){
            // Use job images.
            // Get all the required job images.
            $all_pdf_images = JobImage::where('job_id', $selected_quote->job_id)
                ->where('is_pdf_image', 1) // Is pdf image.
                ->get();
        } else {
            // Use quote images.
            // Pluck ids.
            $image_array = $all_pdf_images->pluck('job_image_id')->toArray();
            // Get all the required job images.
            $all_pdf_images = JobImage::find($image_array);
        }
        // Get all Quote Tasks.
        $all_quote_tasks = QuoteTask::where('quote_id', $selected_quote->id)
            ->whereHas('task', function ($q) {
                return $q->where('is_quote_visible', 1); // Is visible on quote.
            })
            ->orderBy('task_id', 'asc') // Ascending order.
            ->get();
        // Return the show view.
        return view('menu.jobs.customerViewQuote.show')
            ->with([
                'selected_quote' => $selected_quote,
                'selected_system' => $selected_system,
                'all_pdf_images' => $all_pdf_images,
                'all_quote_tasks' => $all_quote_tasks
            ]);
    }
}
