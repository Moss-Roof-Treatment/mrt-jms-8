<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Customer\SendQuotePDFEmail;
use App\Models\Note;
use App\Models\Quote;
use App\Models\QuoteTask;
use App\Models\System;
use App\Models\JobImage;
use Auth;
use Carbon\Carbon;
use PDF;

class EmailQuoteToCustomerController extends Controller
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
    public function create(Request $request)
    {
        // Set The Required Variables.
        // Find the required quote.
        $selected_quote = Quote::find($request->quote_id);
        // Find the required system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.

        // Get PDF images.
        $all_pdf_images = JobImage::where('job_id', $selected_quote->job_id)
            ->where('is_pdf_image', 1) // Is pdf image.
            ->get();

        // Get all Quote Tasks.
        $all_quote_tasks = QuoteTask::where('quote_id', $selected_quote->id)
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

        // EMAIL
        // Check if the selected quote customer has an email address.
        if ($selected_quote->customer->email != null) {
            // Make data variable.
            $data = [
                'recipient_name' => $selected_quote->customer->getFullNameAttribute(),
                'pdf_data' => $pdf->output(),
                'pdf_title' => $pdf_title
            ];
            // Send the email.
            Mail::to($selected_quote->customer->email)
                ->send(new SendQuotePDFEmail($data));
            // Create a new internal note.
            $new_internal_note = Note::create([
                'sender_id' => Auth::id(),
                'job_id' => $selected_quote->job_id,
                'text' => 'Quote ' . $selected_quote->quote_identifier . ' pdf has manually been sent to the customer from within the view selected job page. - ' . Auth::user()->getFullNameAttribute() . '.',
                'is_internal' => 1,
                'jms_seen_at' => Carbon::now(),
                'jms_acknowledged_at' => Carbon::now()
            ]);
            // Return redirect back with the success message.
            return back()
                ->with('success', 'You have successfully sent the selected quote to the customer via email.');
        }

        // The customer does not have an email address.
        // Return a redirect back with the error message.
        return back()
            ->with('danger', 'The selected customer does not have an email address to send the selected quote to.');
    }
}
