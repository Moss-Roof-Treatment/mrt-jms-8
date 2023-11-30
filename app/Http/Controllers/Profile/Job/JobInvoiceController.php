<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Quote;
use App\Models\QuoteRate;
use App\Models\RateUser;
use App\Models\Swms;
use App\Models\User;
use Auth;

class JobInvoiceController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if the GET data has been supplied.
        if(!isset($_GET['selected_quote_id'])) {
            return back()
                ->with('danger', 'The job information is required to manage the job images.');
        }
        // Set The Required Variables.
        // Selected job image.
        $selected_quote = Quote::find($_GET['selected_quote_id']);
        // Authenticated user.
        $selected_tradesperson = User::find(Auth::id());
        // Previous invoice count.
        $previous_invoice_count = Invoice::where('user_id', $selected_tradesperson->id)
            ->count();
        // Find the SWMS.
        $selected_swms = Swms::where('quote_id', $selected_quote->id)
            ->where('tradesperson_id', $selected_tradesperson->id)
            ->first();
        // Secondary validation.
        // Check if the selected SWMS model instance is null.
        if ($selected_swms == null) {
            // There is not SWMS for this quote so return a redirect with a message.
            return back()
                ->with('danger', 'No SWMS has been created for this job. You must complete the Safe Work Methods Statement before completing this job.');
        }
        // Check if the selected SWMS model instance answers array is null.
        if ($selected_swms->answers_array == null) {
            // There is not SWMS answers for this quote so return a redirect with a message.
            return back()
                ->with('danger', 'The SWMS document has not been completed. You must complete the Safe Work Methods Statement before completing this job.');
        }
        // Check if an invoice already exists.
        // Check if the seleced quote has already been invoiced by the auth user.
        $previous_invoice = Invoice::where('quote_id', $selected_quote->id)
            ->where('user_id', $selected_tradesperson->id)
            ->first();
        // Check if previous invoice variable does not equal null.
        if ($previous_invoice != null) {
            // Return a redirect to the tradesperson job show page with error message.
            return redirect()
                ->route('profile-jobs.show', $selected_quote->job_id)
                ->with('danger', 'This job has already been invoiced.');
        }
        // Create the new model instance.
        // Set the required variables for generating the invoice identifier.
        // Uppercase of first letter of first name.
        $first_name_letter = strtoupper(substr($selected_tradesperson->first_name, 0, 1));
        // Uppercase of first letter of first name.
        $last_name_letter = strtoupper(substr($selected_tradesperson->last_name, 0, 1));
        // First letter of the account role type.
        $account_role_letter = strtoupper(substr($selected_tradesperson->account_role->title, 0, 1));
        // Create new invoice.
        $new_invoice = Invoice::create([
            'quote_id' => $selected_quote->id,
            'user_id' => $selected_tradesperson->id,
            'identifier' => $first_name_letter . $last_name_letter . $account_role_letter . ++$previous_invoice_count
        ]);
        // Find the quote rate related to the auth user.
        $selected_tradesperson_quote_rates = QuoteRate::where('quote_id', $selected_quote->id)
            ->where('staff_id', $selected_tradesperson->id)
            ->first();
        // Find the auth users rate_user that matches the quote. 
        $selected_rate_user = RateUser::where('rate_id', $selected_tradesperson_quote_rates->rate_id)
            ->where('user_id', $selected_tradesperson_quote_rates->staff_id)
            ->first();
        // Check if the user has a matching rate.
        if ($selected_rate_user == null) {
            // The user does not have a matching rate so use the defaults.
            // Create new invoice item from quote rate.
            InvoiceItem::create([
                'invoice_id' => $new_invoice->id,
                'job_id' => $new_invoice->quote->job_id,
                'cost' => $selected_tradesperson_quote_rates->individual_price,
                'billable_hours' => $selected_tradesperson_quote_rates->quantity,
                'cost_total' => $selected_tradesperson_quote_rates->individual_price * $selected_tradesperson_quote_rates->quantity,
                'description' => $selected_tradesperson_quote_rates->rate->procedure
            ]);
        } else {
            // The user has a matching rate, so user the matching rate details.
            // Create new invoice item from user rate.
            InvoiceItem::create([
                'invoice_id' => $new_invoice->id,
                'job_id' => $new_invoice->quote->job_id,
                'cost' => $selected_rate_user->price,
                'billable_hours' => $selected_tradesperson_quote_rates->quantity,
                'cost_total' => $selected_rate_user->price * $selected_tradesperson_quote_rates->quantity,
                'description' => $selected_tradesperson_quote_rates->rate->procedure
            ]);
        }
        // Place new invoice id into session.
        // Pull old session variable.
        if (session()->has('selected_invoice_id')) {
            session()->pull('selected_invoice_id');
        }
        // Set new session variable.
        session([
            'selected_invoice_id' => $new_invoice->id,
        ]);
        // Return the index view.
        return redirect()
            ->route('profile-invoices.show', $new_invoice->id);
    }
}
