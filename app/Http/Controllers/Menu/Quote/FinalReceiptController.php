<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\Customer\FinalReceipt;
use App\Models\Event;
use App\Models\JobStatus;
use App\Models\Note;
use App\Models\Quote;
use App\Models\System;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PDF;

class FinalReceiptController extends Controller
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
        // Create a log message.
        Log::info('404 - The selected user has navigated to the index route of a route resource that does not exist.');
        // Return abort 404.
        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Find the required quote.
        $selected_quote = Quote::find($_GET['quote_id']);

        // Set The Required Variables.
        // Find the required system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Set fallback date for the possibility that the final receipt date has not been set.
        $default_date = date('d/m/y', strtotime(Carbon::now()));
        // Create the footer object.
        $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';

        // Generate PDF.
        $pdf = PDF::loadView('menu.quotes.finalReceipt.pdf.create', compact('selected_quote', 'selected_system', 'default_date'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait')
            ->setOption('footer-html', $footer);

        // Make Quote Title variable.
        if ($selected_quote->final_receipt_date == null) {
            // The quote is not finalised yet, no finalised date in the name.
            $pdf_title = $selected_system->acronym . '-final-receipt.pdf';
        } else {
            // The quote is finalised, show the finalised date in the name.
            $pdf_title = $selected_system->acronym . '-' . date('d-m-y', strtotime($selected_quote->final_receipt_date)) . '-final-receipt.pdf';
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
        // Find the required quote model instance.
        $selected_quote = Quote::findOrFail($id);
        // Find the required system model instance.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Return the show view.
        return view('menu.quotes.finalReceipt.show')
            ->with([
                'selected_quote' => $selected_quote,
                'selected_system' => $selected_system
            ]);
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
        // FINALISE AND SEND THE FINAL RECEIPT
        // Set The Required Variables.
        // Find the required quote model instance.
        $selected_quote = Quote::findOrFail($id);
        // Find the required event model instance.
        $selected_event = Event::where('job_id', $selected_quote->job_id)
            ->first();
        // Find the required job status.
        $selected_job_status = JobStatus::find(9); // Paid.
        // Update the selcted model instance.
        $selected_quote->update([
            'quote_status_id' => 7, // Paid.
            'final_receipt_date' => $selected_quote->final_receipt_date == null
                ? Carbon::now()
                : $selected_quote->final_receipt_date
        ]);
        // Update the selected job status.
        $selected_quote->job->update([
            // Update the job status to paid.
            'job_status_id' => $selected_job_status->id // 9 - Paid.
        ]);
        // Check if the selected event does not equal null.
        if ($selected_event != null) {
            // Update the selected event.
            $selected_event->update([
                'description' => 'The job status has been automatically updated to ' . $selected_job_status->title . ' by sending the final receipt to the customer by ' . $request->action . '.',
                'color' => $selected_job_status->color,
                'textColor' => $selected_job_status->text_color
            ]);
        }
        // Create the status change note.
        Note::create([
            'job_id' => $selected_quote->job_id,
            'text' => '"JOB STATUS" changed to "Paid". - ' . Auth::user()->getFullNameAttribute() . '.',
            'is_internal' => 1,
            'profile_job_can_see' => 1, // Is visible on profile job page.
            'jms_seen_at' => Carbon::now(),
            'jms_acknowledged_at' => Carbon::now()
        ]);
        // Garbage Collection.
        $selected_quote->garbageCollection();
        // Check the selected model void date status.
        switch ($request->action) {
            // If the email action button has been clicked.
            case 'email':
                // Check if the selected quote customer has an email address.
                if ($selected_quote->customer->email != null) {
                    // Create the data array to populate the emails with.
                    $data = [
                        'recipient_name' => $selected_quote->customer->getFullNameAttribute()
                    ];
                    // Send the email.
                    Mail::to($selected_quote->customer->email)
                        ->send(new FinalReceipt($data));
                    // Create the new note.
                    Note::create([
                        'job_id' => $selected_quote->job_id,
                        'text' => '"FINAL RECEIPT" email sent to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
                        'is_internal' => 1,
                        'jms_seen_at' => Carbon::now(),
                        'jms_acknowledged_at' => Carbon::now()
                    ]);
                } else {
                    // There is no email address.
                    return back()
                        ->with('warning', 'The selected customer has no email address to receive the final receipt email.');
                }
                // Set the quote as depost receipt as emailed.
                $selected_quote->update([
                    'final_receipt_emailed' => 1
                ]);
                // Return a redirect back.
                return back()
                    ->with('success', 'You have successfully finalised and emailed the final receipt to the customer.');
            break;

            // If the post action button has been clicked.
            case 'post':
                // Create the new note.
                Note::create([
                    'job_id' => $selected_quote->job_id,
                    'text' => '"FINAL RECEIPT" posted to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
                    'is_internal' => 1,
                    'jms_seen_at' => Carbon::now(),
                    'jms_acknowledged_at' => Carbon::now()
                ]);
                // Set the quote as depost receipt as mailed.
                $selected_quote->update([
                    'final_receipt_posted' => 1
                ]);
                // Return a redirect back.
                return back()
                    ->with('success', 'You have successfully finalised and marked the final receipt as posted to the customer.');
            break;
            // The default catch action.
            default:
                // Return a 404.
                return abort(404);
        }
    }
}
