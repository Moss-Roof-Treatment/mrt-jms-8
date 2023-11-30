<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\ExpectedPaymentMethod;
use App\Models\JobImage;
use App\Models\PaymentMethod;
use App\Models\PaymentType;
use App\Models\Quote;
use App\Models\QuoteStatus;
use App\Models\QuoteRequest;

class QuoteController extends Controller
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
        // All quote statuses.
        $all_quote_statuses = QuoteStatus::all('id', 'title')
            ->sortBy('id');
        // QUOTE REQUESTS
        // All quote requests with a status that is not finished.
        $pending_quote_requests_count = QuoteRequest::where('quote_request_status_id', '!=', 3) // Finished.
            ->count();
        // Return the index view.
        return view('menu.quotes.index')
            ->with([
                'all_quote_statuses' => $all_quote_statuses,
                'pending_quote_requests_count' => $pending_quote_requests_count
            ]);
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
        $selected_quote = Quote::with('quote_products')
            ->with('quote_tasks')
            ->with('quote_tasks.task')
            ->with('quote_tasks.task.dimension')
            ->with('quote_tasks.task.task_type')
            ->with('quote_rates')
            ->with('quote_rates.staff')
            ->with('job_type')
            // ->with('customer')
            ->findOrFail($id);
        // Set The Required Variables.
        // All quote statuses.
        $all_quote_statuses = QuoteStatus::all();
        // Check if the quote is finalised.
        if ($selected_quote->finalised_date == null) {
            // Job Images.
            // Find all images belonging to the the selected job and order them by
            $all_job_images = JobImage::where('job_id', $selected_quote->job_id)
                ->with('staff')
                ->get();
            // Group job images by image type id.
            $image_type_collections = $all_job_images->groupBy('job_image_type_id');
            // Unfinalised quote.
            // return the unfinalised quote view.
            return view('menu.quotes.show')
                ->with([
                    'all_quote_statuses' => $all_quote_statuses,
                    'selected_quote' => $selected_quote,
                    'image_type_collections' => $image_type_collections
                ]);
        } else {
            // Finalised quote.
            // Set The Required Variables.
            // New online quote access email template.
            $selected_email_template = EmailTemplate::find(7); // Online quote access email.
            // All Payment methods.
            $all_payment_methods = PaymentMethod::all('id', 'title');
            // All Payment Types.
            $all_payment_types = PaymentType::all('id', 'title');
            // All expected payment methods.
            $all_expected_payment_methods = ExpectedPaymentMethod::orderBy('id')
                ->select('id', 'title')
                ->get();
            // return the finalised quote view.
            return view('menu.quotes.finalised.show')
                ->with([
                    'all_expected_payment_methods' => $all_expected_payment_methods,
                    'all_payment_methods' => $all_payment_methods,
                    'all_payment_types' => $all_payment_types,
                    'all_quote_statuses' => $all_quote_statuses,
                    'selected_quote' => $selected_quote,
                    'selected_email_template' => $selected_email_template
                ]);
        }
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
            'profit_margin' => 'required|numeric',
            'discount' => 'required|numeric',
        ]);
        // Find the required model instance.
        $selected_quote = Quote::findOrFail($id);
        // Format the profit margin from the request.
        $profit_margin = preg_replace('/[$.,]/', '', $request->profit_margin);
        // Format the discount from the request.
        $discount = preg_replace('/[$.,]/', '', $request->discount);
        // Update the selected model instance.
        $selected_quote->update([
            'profit_margin' => $profit_margin,
            'discount' => $discount
        ]);
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected quote.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $selected_quote = Quote::findOrFail($id);

        $selected_quote->delete();

        return back()
            ->with('success', 'You have successfully deleted the selected quote.');
    }
}
