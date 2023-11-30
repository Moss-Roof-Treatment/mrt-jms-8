<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Quote;
use App\Models\QuoteRequest;
use App\Models\InspectionType;
use App\Models\Job;
use App\Models\JobStatus;
use App\Models\Event;
use App\Models\JobType;
use App\Models\QuoteProduct;
use App\Models\System;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class ConvertQuoteRequestController extends Controller
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
        // Find the required customer.
        // Find the required quote request.
        // Set The Required Variables.
        // Return a redirect to the create view.

        // Check if the required GET variables have been supplied in the URL.
        if (!isset($_GET['selected_customer_id']) || !isset($_GET['selected_customer_id'])) {
            return abort(404);
        }

        $selected_customer = User::findOrFail($_GET['selected_customer_id']);

        $selected_quote_request = QuoteRequest::findOrFail($_GET['selected_quote_request_id']);

        // Inspection Types.
        $inspection_types = InspectionType::all('id', 'title');

        // Job Types.
        $job_types = JobType::all('id', 'title');

        // All staff users.
        $staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('id', '!=', 1) // Not the first user in the database.
            ->where('login_status_id', 1) // 1 = Is Active.
            ->with('account_role')
            ->get();

        return view('menu.quotes.requests.create')
            ->with([
                'selected_customer' => $selected_customer, 
                'selected_quote_request' => $selected_quote_request, 
                'staff_members' => $staff_members,
                'inspection_types' => $inspection_types,
                'job_types' => $job_types,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Find the required user.
        $selected_customer = User::findOrFail($request->selected_customer_id);

        // Find the required quote request.
        $selected_quote_request = QuoteRequest::findOrFail($request->selected_quote_request_id);

        // Generate Start Timestamp.
        $event_start_date = Carbon::parse($request->inspection_date_time);
        // Generate End Timestamp.
        $event_end_date = Carbon::parse($request->inspection_date_time)->addHour(2); // Add 2 hours.

        // New job status.
        $new_job_status = JobStatus::find(2); // New job status.

        // Create new job model instance.
        $new_job = Job::create([
            'customer_id' => $selected_customer->id,
            'salesperson_id' => $request->salesperson_id,
            'tenant_name' => $request->tenant_name,
            'tenant_home_phone' => str_replace(' ', '', $request->tenant_home_phone),
            'tenant_mobile_phone' => str_replace(' ', '', $request->tenant_mobile_phone),
            'tenant_street_address' => $request->tenant_street_address,
            'tenant_suburb' => $request->tenant_suburb,
            'tenant_postcode' => $request->tenant_postcode,
            'job_progress_id' => 1, // Pending.
            'job_status_id' => 2, // New.
            'follow_up_call_status_id' => 1, // None.
            'quote_sent_status_id' => 1, // None.
            'inspection_type_id' => $request->inspection_type_id,
            'inspection_date' => $event_start_date,
            'start_date_null' => 1
        ]);
        // Create job type model relationship instances.
        // Create pivot table entries with array of selected job types.
        $new_job->job_types()->sync($request->job_types);

        $new_quote = Quote::create([
            'job_id' => $new_job->id,
            'customer_id' => $selected_customer->id,
            'quote_status_id' => 1 // New.
        ]);

        // create the commission object.
        $new_quote->createQuoteCommission();


        // CREATE THE FUEL DEFAULT ITEM
        // Create new fuel product item.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Create the required variables.
        $default_petrol_price = $selected_system->default_petrol_price / 100;
        $default_litres_per_km = $selected_system->default_petrol_usage;
        $default_distance = 10; // This is used for having something as a quantity rather than just none or 1.
        // Perform the equasion. Fuel cost = (Distance / 100 × Consumption) × Cost per litre.
        $calculated_price = ($default_distance / 100 * $default_litres_per_km) * $default_petrol_price;
        // Create the quote product.
        QuoteProduct::create([
            'quote_id' => $new_quote->id, // The new quote.
            'product_id' => 6, // The ID of the petrol product.
            'quantity' => 10, // This is set to one because it is a total value not a single unit that needs to be multiplied.
            'individual_price' => number_format(($selected_system->default_petrol_price / 100), 2, '.'), // This is a double for some reason ?????
            'total_price' => intval(number_format(floor($calculated_price*100)/100,2, '', '')), // Double value converted to int.
            'price_per_litre' => $selected_system->default_petrol_price,
            'usage_per_100_kms' => $default_litres_per_km,
        ]);


        // Find the required event
        $selected_event = Event::where('quote_request_id', $selected_quote_request->id)
            ->first();

        if ($selected_event == null) {
            // DELETE THIS WHEN LIVE! THE EVENT WOULD BE CREATED BY THE CUSTOMER. ???????????????
            // The event was not found so it needs to be created.
            Event::create([
                'quote_request_id' => $selected_quote_request->id,
                'job_id' => $new_job->id,
                'quote_id' => $new_quote->id,
                'user_id' => Auth::id(), // The person creating the event.
                'title' => $new_job->id . '-' . $new_job->tenant_suburb,
                'description' => 'The save and continue button was pressed after the quote request form was completed and a quote has been created. No inspection is required for this quote.',
                'color' => $new_job_status->color,
                'textColor' => $new_job_status->text_color,
                'start' => $event_start_date,
                'end' => $event_end_date
            ]);
        } else {
            // The event has been found, so update the event.
            $selected_event->update([
                'quote_request_id' => $selected_quote_request->id,
                'job_id' => $new_job->id,
                'quote_id' => $new_quote->id,
                'user_id' => Auth::id(), // The person creating the event.
                'title' => $new_job->id . '-' . $new_job->tenant_suburb,
                'description' => 'The save and continue button was pressed after the quote request form was completed and a quote has been created. No inspection is required for this quote.',
                'color' => $new_job_status->color,
                'textColor' => $new_job_status->text_color,
                'start' => $event_start_date,
                'end' => $event_end_date
            ]);
        }

        $selected_quote_request->update([
            'job_id' => $new_job->id,
            'quote_request_status_id' => 3, // Completed
            'is_delible' => 0 // Completed
        ]);

        // Reset the quote identifiers of all quotes related to the selected job.
        $new_job->resetQuoteIdentifiers();

        return redirect()
            ->route('quick-quote.show', $new_quote->id)
            ->with('success', 'Success Continue');
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
        // Set The Required Variables.
        // Check if the entered email address already belongs to a customer.
        // If the email does not belong to a customer create a new one and set them as the selected customer.
        // If the email does belong to a customer set them as the selected customer.

        // Check if the quote request is created by the customer or a staff member. 
        // If created by staff member, create a new quote and return a redirect to the quick quote show route.
        // If created by a customer return a redirect to the create method, with the selected customer id and the selected quote request id.

        $selected_quote_request = QuoteRequest::findOrFail($id);

        $selected_customer = User::where('email', $selected_quote_request->email)
            ->first();

        if ($selected_customer == null) {

            // GENERATE A PASSWORD
            // Set the available characters string.
            $chars = "abcdefghmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
            // Shuffle the characters string and trim the first 8 characters.
            $random_string = substr(str_shuffle($chars),0,8);

            $selected_customer = User::create([
                'account_class_id' => 5, // Individual.
                'account_role_id' => 5, // Customer.
                'referral_id' => 39, // MRT Website - This is really online quote request.
                'username' => $selected_quote_request->email,
                'email' => $selected_quote_request->email,
                'password' => bcrypt($random_string), // Random string of characters.
                'first_name' => ucfirst($selected_quote_request->first_name),
                'last_name' => ucfirst($selected_quote_request->last_name),
                'street_address' => ucwords($selected_quote_request->street_address),
                'suburb' => ucwords($selected_quote_request->suburb),
                'state_id' => 7, // Victoria
                'postcode' => $selected_quote_request->postcode,
                'home_phone' => $selected_quote_request->home_phone,
                'mobile_phone' => $selected_quote_request->mobile_phone
            ]);
        }

        if ($selected_quote_request->is_customer_generated == 0) { // Created by a staff member.

            $new_quote = Quote::create([
                'job_id' => $selected_quote_request->job_id,
                'customer_id' => $selected_customer->id,
                'quote_status_id' => 1 // New.
            ]);

            // Create the initial commission object.
            $new_quote->createQuoteCommission();

            // CREATE THE FUEL DEFAULT ITEM
            // Create new fuel product item.
            $selected_system = System::firstOrFail(); // Moss Roof Treatment.
            // Create the required variables.
            $default_petrol_price = $selected_system->default_petrol_price / 100;
            $default_litres_per_km = $selected_system->default_petrol_usage;
            $default_distance = 10; // This is used for having something as a quantity rather than just none or 1.
            // Perform the equasion. Fuel cost = (Distance / 100 × Consumption) × Cost per litre.
            $calculated_price = ($default_distance / 100 * $default_litres_per_km) * $default_petrol_price;
            // Create the quote product.
            QuoteProduct::create([
                'quote_id' => $new_quote->id, // The new quote.
                'product_id' => 6, // The ID of the petrol product.
                'quantity' => 10, // This is set to one because it is a total value not a single unit that needs to be multiplied.
                'individual_price' => number_format(($selected_system->default_petrol_price / 100), 2, '.'), // This is a double for some reason ?????
                'total_price' => intval(number_format(floor($calculated_price*100)/100,2, '', '')), // Double value converted to int.
                'price_per_litre' => $selected_system->default_petrol_price,
                'usage_per_100_kms' => $default_litres_per_km,
            ]);

            $selected_quote_request->update([
                'quote_request_status_id' => 3, // Completed.
                'is_delible' => 0 // is not delible.
            ]);

            // Reset the quote identifiers of all quotes related to the selected job.
            $selected_quote_request->job->resetQuoteIdentifiers();

            return redirect()
                ->route('quick-quote.show', $new_quote->id)
                ->with('success', 'You have converted the quote request, now complete the quick quote form.');

        } else { // Created by a customer.

            return redirect()
                ->route('convert-quote-requests.create', ['selected_customer_id' => $selected_customer->id, 'selected_quote_request_id' => $selected_quote_request->id])
                ->with('success', 'Please continue by completing the job create form.');
        }
    }
}
