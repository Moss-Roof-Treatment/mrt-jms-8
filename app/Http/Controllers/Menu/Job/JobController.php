<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuildingStyle;
use App\Models\BuildingType;
use App\Models\EmailTemplate;
use App\Models\Event;
use App\Models\FollowUpCallStatus;
use App\Models\InspectionType;
use App\Models\Job;
use App\Models\JobType;
use App\Models\JobImage;
use App\Models\JobProgress;
use App\Models\JobStatus;
use App\Models\JobJobType;
use App\Models\MaterialType;
use App\Models\Note;
use App\Models\Quote;
use App\Models\QuoteProduct;
use App\Models\QuoteRequest;
use App\Models\QuoteSentStatus;
use App\Models\SmsTemplate;
use App\Models\Swms;
use App\Models\System;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class JobController extends Controller
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
        // Find all the required model instances.
        $all_jobs = Job::all();
        // Set The Required Variables.
        // All job statuses sorted by id.
        $all_job_statuses = JobStatus::all('id', 'title')
            ->sortBy('id');
        // Return the index view.
        return view('menu.jobs.index')
            ->with([
                'all_job_statuses' => $all_job_statuses,
                'all_jobs' => $all_jobs
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check if the required GET variable has been supplied in the URL.
        if (!isset($_GET['selected_customer_id'])) {
            // The Get variable was not supplied in the URL.
            // Return a 404.
            return abort(404);
        }
        // Set The Required Variables.
        $selected_customer = User::findOrFail($_GET['selected_customer_id']);
        // Staff Members
        $staff_members = User::where('id', '!=', 1)
            ->whereIn('account_role_id', [1, 2]) // Staff
            ->where('login_status_id', 1) // 1 = Is Active.
            ->select('id', 'first_name', 'last_name')
            ->get();
        // Building Styles.
        $building_styles = BuildingStyle::all('id', 'title');
        // Building Types.
        $building_types = BuildingType::all('id', 'title');
        // Inspection Types.
        $inspection_types = InspectionType::all('id', 'title');
        // Job Types.
        $job_types = JobType::all('id', 'title');
        // Material Types.
        $material_types = MaterialType::all('id', 'title');
        // Return the create view.
        return view('menu.jobs.create')
            ->with([
                'building_styles' => $building_styles,
                'building_types' => $building_types,
                'selected_customer' => $selected_customer,
                'inspection_types' => $inspection_types,
                'job_types' => $job_types,
                'material_types' => $material_types,
                'staff_members' => $staff_members
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
        // Validate The Request Data.
        $request->validate([
            'salesperson_id' => 'required',
            'tenant_name' => 'nullable|string|min:2|max:60',
            'tenant_home_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:tenant_mobile_phone',
            'tenant_mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:tenant_home_phone',
            'tenant_street_address' => 'required|string|min:8|max:100',
            'tenant_suburb' => 'required|string|min:3|max:60',
            'tenant_postcode' => 'required|numeric|min:1000|max:9999',
            'inspection_type_id' => 'required',
            'inspection_date_time' => 'sometimes|nullable|string',
            'inspection_date_null' => 'required_without:inspection_date_time',
            'job_types' => 'required',
            'building_style_id' => 'required',
            'has_water_tanks' => 'required'
        ]);
        // Set The Required Variables.
        // Find the required customer model instance.
        $selected_customer = User::findOrFail($request->selected_customer_id);
        // Staff Memeber.
        $selected_staff_member = User::find(Auth::id());
        // System.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Generate Start Timestamp.
        $event_start_date = Carbon::parse($request->inspection_date_time);
        // Generate End Timestamp.
        $event_end_date = Carbon::parse($request->inspection_date_time)->addHour(2); // Add 2 hours.
        // Quote Request job status.
        $quote_request_job_status = JobStatus::find(1); // Quote Request job status.
        // New job status.
        $new_job_status = JobStatus::find(2); // New job status.
        // Create new job model instance.
        $new_job = Job::create([
            'customer_id' => $selected_customer->id,
            'salesperson_id' => $request->salesperson_id,
            'label' => $request->label,
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
        // Create the quote request. 
        // Create a new quote request model instance.
        $new_quote_request = QuoteRequest::create([
            'staff_id' => Auth::id(),
            'quote_request_status_id' => 1, // New.
            'first_name' => $selected_customer->first_name,
            'last_name' => $selected_customer->last_name,
            'username' => $selected_customer->username,
            'email' => $selected_customer->email,
            'home_phone' => $selected_customer->home_phone,
            'street_address' => $selected_customer->street_address,
            'suburb' => $selected_customer->suburb,
            'postcode' => $selected_customer->postcode,
            'job_id' => $new_job->id,
            'building_style_id' => $request->building_style_id,
            'house' => isset($request->house) ? 1 : 0,
            'carport' => isset($request->carport) ? 1 : 0,
            'veranda' => isset($request->veranda) ? 1 : 0,
            'pergola' => isset($request->pergola) ? 1 : 0,
            'garage' => isset($request->garage) ? 1 : 0,
            'garden_shed' => isset($request->garden_shed) ? 1 : 0,
            'barn' => isset($request->barn) ? 1 : 0,
            'retirement_village' => isset($request->retirement_village) ? 1 : 0,
            'industrial_shed' => isset($request->industrial_shed) ? 1 : 0,
            'house_unit' => isset($request->house_unit) ? 1 : 0,
            'school_buildings' => isset($request->school_buildings) ? 1 : 0,
            'church' => isset($request->church) ? 1 : 0,
            'shops' => isset($request->shops) ? 1 : 0,
            'iron' => isset($request->iron) ? 1 : 0,
            'slate' => isset($request->slate) ? 1 : 0,
            'laserlight' => isset($request->laserlight) ? 1 : 0,
            'cement' => isset($request->cement) ? 1 : 0,
            'terracotta' => isset($request->terracotta) ? 1 : 0,
            'paint' => isset($request->paint) ? 1 : 0,
            'solar_panels' => isset($request->solar_panels) ? 1 : 0,
            'air_conditioner' => isset($request->air_conditioner) ? 1 : 0,
            'pool_heating' => isset($request->pool_heating) ? 1 : 0,
            'under_aerial' => isset($request->under_aerial) ? 1 : 0,
            'additions_laserlight' => isset($request->additions_laserlight) ? 1 : 0,
            'outside_of_gutters' => isset($request->outside_of_gutters) ? 1 : 0,
            'additions_other' => $request->additions_other,
            'further_information' => $request->further_information,
            'is_delible' => 0, // Not Delible.
        ]);
        // Check for required action.
        // Check which submit button was pressed.
        switch ($request->action) {
                // Continue button clicked.
            case 'continue':
                // Create New Quote.
                $new_quote = Quote::create([
                    'job_id' => $new_job->id,
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
                    'total_price' => intval(number_format(floor($calculated_price * 100) / 100, 2, '', '')), // Double value converted to int.
                    'price_per_litre' => $selected_system->default_petrol_price,
                    'usage_per_100_kms' => $default_litres_per_km,
                ]);

                // Reset the quote identifiers of all quotes related to the selected job.
                $new_job->resetQuoteIdentifiers();
                // Update the selected quote request.
                $new_quote_request->update([
                    'quote_request_status_id' => 3, // Complete.
                    'is_delible' => 0 // Completed
                ]);
                // Create the required event.
                // Check if inspection date null is set.
                if (isset($request->inspection_date_null)) {
                    // Quote Request Event
                    // The inspection date null isset, create a quote request event.
                    // Create the new event.
                    Event::create([
                        'quote_request_id' => $new_quote_request->id,
                        'job_id' => $new_job->id,
                        'quote_id' => $new_quote->id,
                        'user_id' => $selected_staff_member->id, // The person creating the event.
                        'title' => $new_job->id . '-' . $new_job->tenant_suburb,
                        'description' => 'The save and continue button was pressed after the quote request form was completed and a quote has been created. No inspection is required for this quote.',
                        'color' => $new_job_status->color,
                        'textColor' => $new_job_status->text_color,
                        'start' => $event_start_date,
                        'end' => $event_end_date
                    ]);
                } else {
                    // Inspection Event
                    // The inspection date null is not set, create an inspection event.
                    // Create the new event.
                    Event::create([
                        'quote_request_id' => $new_quote_request->id,
                        'job_id' => $new_job->id,
                        'quote_id' => $new_quote->id,
                        'user_id' => $selected_staff_member->id, // The person creating the event.
                        'title' => $new_job->id . '-' . $new_job->tenant_suburb,
                        'description' => 'The save and continue button was pressed after the quote request form was completed and a quote has been created. An inspection is required for this quote.',
                        'color' => $new_job_status->color,
                        'textColor' => $new_job_status->text_color,
                        'start' => $event_start_date,
                        'end' => $event_end_date
                    ]);
                }
                // Continue to the quick quote create page.
                // Return a redirect to the quick quote show route.
                return redirect()
                    ->route('quick-quote.show', $new_quote->id)
                    ->with('success', 'Success Continue');
                break;
                // Finished button clicked.
            case 'finish':
                // If an inspection is required create an inspection event, else set a quote request event. 
                // Check if inspection date null is set.
                if (isset($request->inspection_date_null)) {
                    // Quote Request Event
                    // The inspection date null isset, create a quote request event.
                    // Create the new event.
                    Event::create([
                        'quote_request_id' => $new_quote_request->id,
                        'job_id' => $new_job->id,
                        'user_id' => $selected_staff_member->id, // The person creating the event.
                        'title' => 'New Quote Request',
                        'description' => 'A new quote request has been created in the JMS. No inspection date has been set.',
                        'color' => $quote_request_job_status->color,
                        'textColor' => $quote_request_job_status->text_color,
                        'start' => $event_start_date,
                        'end' => $event_end_date
                    ]);
                } else {
                    // Inspection Event
                    // The inspection date null is not set, create an inspection event.
                    // Create the new event.
                    Event::create([
                        'quote_request_id' => $new_quote_request->id,
                        'job_id' => $new_job->id,
                        'staff_id' => 2, // Stuart - The host of the event - Chosen by the customer.
                        'user_id' => $selected_staff_member->id, // The person creating the event.
                        'title' => 'New inspection request',
                        'description' => 'A new quote request has been created in the JMS. An inspection date has been set.',
                        'color' => $new_job_status->color,
                        'textColor' => $new_job_status->text_color,
                        'start' => $event_start_date,
                        'end' => $event_end_date,
                    ]);
                }
                // The incomming call process is complete, The quotation process is to be completed at a later time.
                // Return a redirect to the job show page and display the newly created job.
                return redirect()
                    ->route('jobs.show', $new_job->id)
                    ->with('success', 'Success Finish');
                break;
                // Default action.
            default:
                // Something wrong has happened.
                // Return a 404.
                return abort(404);
        }
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
        $selected_job = Job::with(['customer', 'salesperson', 'quote_request', 'quote_request.quote_request_images'])
            ->findOrFail($id);
        // Set The Required Variables.
        // Notes
        // All public job notes.
        $all_public_notes = Note::where('job_id', $id)
            ->where('is_internal', 0)
            ->orderBy('id', 'desc')
            ->get();
        // All internal notes.
        $all_internal_notes = Note::where('job_id', $id)
            ->where('is_internal', 1)
            ->orderBy('id', 'desc')
            ->get();
        // Images
        // Job Images.
        // Find all images belonging to the the selected job and order them by
        $all_job_images = JobImage::where('job_id', $id)
            ->with('staff')
            ->get();
        // Group job images by image type id.
        $image_type_collections = $all_job_images->groupBy('job_image_type_id');
        // PDF Images.
        $all_pdf_images = JobImage::where('job_id', $id)
            ->where('is_pdf_image', 1) // PDF Images.
            ->get();
        // All Statuses.
        // All quote sent status - for dropdown.
        $quote_sent_statuses = QuoteSentStatus::all('id', 'title');
        // All job progress statuses - for dropdown.
        $job_progresses = JobProgress::all('id', 'title');
        // All follow up call statuses - for dropdown.
        $all_follow_up_call_statuses = FollowUpCallStatus::where('is_selectable', 1)
            ->orderby('colour_id')
            ->with('colour')
            ->get();
        // All job statuses - for dropdown.
        $all_job_statuses = JobStatus::all('id', 'title')
            ->sortBy('id');
        // SWMS
        // Find all the quote ids.
        $all_quote_ids = Quote::where('job_id', $id)->pluck('id')->toArray();
        // Find all SWMS from quote ids array.
        $all_swms = Swms::whereIn('quote_id', $all_quote_ids)
            ->get();
        // Find all the required emails.
        $selected_email_template = EmailTemplate::find(21); // Start Date Changed.
        // Find all the required emails.
        $selected_sms_template = SmsTemplate::find(9); // Start Date Changed.
        // All sms templates.
        $all_sms_templates = SmsTemplate::select('id', 'title') // Select only id and title.
            ->whereNotIn('id', [1, 2]) // where not generic or testing sms.
            ->get();
        // Return the show view.
        return view('menu.jobs.show')
            ->with([
                'selected_job' => $selected_job,
                'all_public_notes' => $all_public_notes,
                'all_internal_notes' => $all_internal_notes,
                'image_type_collections' => $image_type_collections,
                'quote_sent_statuses' => $quote_sent_statuses,
                'job_progresses' => $job_progresses,
                'all_follow_up_call_statuses' => $all_follow_up_call_statuses,
                'all_pdf_images' => $all_pdf_images,
                'all_job_statuses' => $all_job_statuses,
                'selected_email_template' => $selected_email_template,
                'selected_sms_template' => $selected_sms_template,
                'all_swms' => $all_swms,
                'all_sms_templates' => $all_sms_templates
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the required model instance.
        $selected_job = Job::findOrFail($id);
        // Set The Required Variables.
        // All Staff Members.
        $staff_members = User::where('id', '!=', 1)
            ->whereIn('account_role_id', [1, 2]) // Staff
            ->select('id', 'first_name', 'last_name')
            ->get();
        // All Building Types.
        $building_types = BuildingType::all('id', 'title');
        // All Building Styles.
        $building_styles = BuildingStyle::all('id', 'title');
        // All Inspection Types.
        $inspection_types = InspectionType::all('id', 'title');
        // All Material Types.
        $material_types = MaterialType::all('id', 'title');
        // All Job Types.
        $job_types = JobType::all('id', 'title');
        // All Selected Job Job Types Model Relationships.
        $selected_job_types = JobJobType::where('job_id', $selected_job->id)
            ->pluck('job_type_id')->toArray();
        // Return the job edit view.
        return view('menu.jobs.edit')
            ->with([
                'building_styles' => $building_styles,
                'building_types' => $building_types,
                'selected_job' => $selected_job,
                'inspection_types' => $inspection_types,
                'job_types' => $job_types,
                'material_types' => $material_types,
                'selected_job_types' => $selected_job_types,
                'staff_members' => $staff_members
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
        // Validate The Request Data.
        $request->validate([
            'salesperson_id' => 'required',
            'tenant_name' => 'nullable|string|min:2|max:60',
            'tenant_home_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:tenant_mobile_phone',
            'tenant_mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:tenant_home_phone',
            'tenant_street_address' => 'required|string|min:8|max:100',
            'tenant_suburb' => 'required|string|min:3|max:60',
            'tenant_postcode' => 'required|numeric|min:1000|max:9999',
            'material_type_id' => 'sometimes|nullable',
            'building_style_id' => 'sometimes|nullable',
            'building_type_id' => 'sometimes|nullable',
            'inspection_date_time' => 'sometimes|nullable|string',
            'job_types' => 'required'
        ]);
        // Set The Required Variables.
        $selected_job = Job::findOrFail($id);
        // Update the selected model instance.
        $selected_job->update([
            'salesperson_id' => $request->salesperson_id,
            'label' => $request->label,
            'tenant_name' => $request->tenant_name,
            'tenant_home_phone' => str_replace(' ', '', $request->tenant_home_phone),
            'tenant_mobile_phone' => str_replace(' ', '', $request->tenant_mobile_phone),
            'tenant_street_address' => $request->tenant_street_address,
            'tenant_suburb' => $request->tenant_suburb,
            'tenant_postcode' => $request->tenant_postcode,
            'material_type_id' => $request->material_type_id,
            'building_style_id' => $request->building_style_id,
            'building_type_id' => $request->building_type_id,
            'inspection_type_id' => $request->inspection_type_id,
            'inspection_date' => Carbon::parse($request->inspection_date_time) // Carbon parsed start date.
        ]);
        // Update the job type model relationships.
        // Create pivot table entries with array of selected job types.
        $selected_job->job_types()->sync($request->job_types);
        // Return a redirect to the show route.
        return redirect()
            ->route('jobs.show', $id)
            ->with('success', 'You have successfully updated the selected job.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required model instance.
        $selected_job = Job::findOrFail($id);
        // Delete images from storage.
        // Check if the quote request relationship exists.
        if ($selected_job->quote_request?->has('quote_request_images')) {
            // Loop through each quote request image.
            foreach ($selected_job->quote_request->quote_request_images as $quote_request_image) {
                // Check if image path is not null.
                if ($quote_request_image->image_path != null) {
                    // Check if file exists.
                    if (file_exists(public_path($quote_request_image->image_path))) {
                        // Delete the image if it exists.
                        unlink(public_path($quote_request_image->image_path));
                    }
                }
            }
        }
        // Loop through each job image.
        foreach ($selected_job->job_images as $job_image) {
            // Check if image path is not null.
            if ($job_image->image_path != null) {
                // Check if file exists.
                if (file_exists(public_path($job_image->image_path))) {
                    // Delete the image if it exists.
                    unlink(public_path($job_image->image_path));
                }
            }
        }
        // Delete job model instance.
        $selected_job->delete();
        // Return a redirect to the jobs index route.
        return redirect()
            ->route('jobs.index')
            ->with('success', 'You have successfully deleted the selected job.');
    }
}
