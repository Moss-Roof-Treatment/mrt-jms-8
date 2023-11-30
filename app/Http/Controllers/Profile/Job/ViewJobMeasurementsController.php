<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\JobImage;
use App\Models\JobImageQuote;
use PDF;

class ViewJobMeasurementsController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check if the GET data has been supplied.
        if(!isset($_GET['selected_quote_id'])) {
            return back()
                ->with('danger', 'The job information is required to view the measurements.');
        }
        // Set The Required Variables.
        $selected_quote = Quote::find($_GET['selected_quote_id']);
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
        // Create the footer object.
        $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';
        // Generate PDF.
        $pdf = PDF::loadView('profile.jobs.measurements.create', compact('selected_quote', 'all_pdf_images'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait')
            ->setOption('footer-html', $footer);
        // Set pdf title
        $pdf_title = $selected_quote->quote_identifier . '-job-measurements.pdf';
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
        // Find the required model instance.
        $selected_quote = Quote::findOrFail($id);
        // Set The Required Variables.
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
        // Return the show view.
        return view('profile.jobs.measurements.show')
            ->with([
                'all_pdf_images' => $all_pdf_images,
                'selected_quote' => $selected_quote,
            ]);
    }
}
