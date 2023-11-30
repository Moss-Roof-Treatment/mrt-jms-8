<?php

namespace App\Http\Controllers\Menu\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\BuildingStyle;
use App\Models\BuildingType;
use App\Models\DefaultAdditionalComment;
use App\Models\DefaultPropertiesToView;
use App\Models\DoubleStoreySurcharge;
use App\Models\Event;
use App\Models\InspectionType;
use App\Models\Job;
use App\Models\JobImage;
use App\Models\JobImageType;
use App\Models\JobJobType;
use App\Models\JobType;
use App\Mail\Customer\NewJobNote;
use App\Models\QuoteCommission;
use App\Models\MaterialType;
use App\Models\Note;
use App\Models\Quote;
use App\Models\QuoteProduct;
use App\Models\QuoteRequest;
use App\Models\QuoteRate;
use App\Models\QuoteTask;
use App\Models\Rate;
use App\Models\RoofPitchMultiplyFactor;
use App\Models\System;
use App\Models\Task;
use App\Models\TaskPriceRange;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class QuickQuoteController extends Controller
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
        // Check if the required GET variable has been supplied in the URL.
        if (!isset($_GET['selected_job_id'])) {
            return abort(404);
        }
        // Find the required job using the supplied session variable. 
        $selected_job = Job::findOrFail($_GET['selected_job_id']);
        // Find the required quote request.
        $selected_quote_request = QuoteRequest::where('job_id', $selected_job->id)->first();
        // Create a new quote.
        $new_quote = Quote::create([
            'job_id' => $selected_job->id,
            'customer_id' => $selected_job->customer_id,
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


        // Update the selected quote request.
        $selected_quote_request->update([
            'quote_request_status_id' => 3, // Completed.
            'is_delible' => 0 // is not delible.
        ]);
        // Reset the quote identifiers of all quotes related to the selected job.
        $selected_job->resetQuoteIdentifiers();
        // Return a redirect to the show route.
        return redirect()
            ->route('quick-quote.show', $new_quote->id)
            ->with('success', 'You have successfully created a new quick quote.');
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
        $selected_quote = Quote::where('id', $id)
            ->with('customer')
            ->with('job')
            ->with('commissions.salesperson')
            ->with('job.building_type')
            ->with('job.material_type')
            ->with('job.job_types')
            ->with('job.quote_request')
            ->with('job.quote_request.building_style')
            ->firstOrFail();
        // ALL TASKS
        // Areas to be treated
        $all_areas_to_be_treated_quote_tasks = QuoteTask::where('quote_id', $selected_quote->id)
            ->whereRelation('task', 'task_type_id', 1)
            ->with('task')
            ->get();
        // Additions
        $all_additions_quote_tasks = QuoteTask::where('quote_id', $selected_quote->id)
            ->whereRelation('task', 'task_type_id', 2)
            ->get();
        // Available additions to select.
        $all_available_additions = Task::where('task_type_id', 2) // Additions.
            ->where('is_selectable', 1)
            ->get();
        // Other Works
        $all_other_works_quote_tasks = QuoteTask::where('quote_id', $selected_quote->id)
            ->whereRelation('task', 'task_type_id', 3)    
            ->get();
        // Available other works to select.
        $all_available_other_works = Task::where('task_type_id', 3) // Other works.
            ->where('is_selectable', 1)
            ->get();
        // Fuel Product
        $fuel_product = QuoteProduct::where('quote_id', $selected_quote->id)
            ->where('product_id', 6)
            ->first();
        // All default additional comments.
        $all_default_additional_comments = DefaultAdditionalComment::select(['id', 'text'])->get();
        // All default properties to view.
        $all_default_properties_to_view = DefaultPropertiesToView::select(['id', 'title'])->get();
        // Building Styles.
        $building_styles = BuildingStyle::where('id', '!=', 3)->get(); // Not single and double storey. 
        // Building Types.
        $building_types = BuildingType::all('id', 'title');
        // Inspection Types.
        $inspection_types = InspectionType::all('id', 'title');
        // Material Types.
        $material_types = MaterialType::all('id', 'title');

        // Staff Members
        $staff_members = User::where('id', '!=', 1) // Not Qontrol User.
            ->whereIn('account_role_id', [1,2]) // Staff.
            ->where('login_status_id', 1) // 1 = Is Active.
            ->with('account_role')
            ->get(); // Staff Members

        // Job Types.
        $job_types = JobType::all('id', 'title');

        // Rates.
        $all_rates = Rate::where('is_selectable', 1)
            ->get();

        // JOB TYPES
        // Selected Job Types
        $selected_job_types = JobJobType::where('job_id', $selected_quote->job_id)
            ->pluck('job_type_id')
            ->toArray();

        // JOB IMAGE TYPES
        // Find the required image types from the array.
        $image_types = JobImageType::whereIn('id', [3,4]) // 3 - roof outline, 4 - before.
            ->select('id', 'title')
            ->get();

        // All job images.
        $job_images = JobImage::where('job_id', $selected_quote->job_id)
            ->orderBy('job_image_type_id', 'asc')
            ->with('staff')
            ->with('job_image_type')
            ->get();

        // Group job images by their image type.
        $image_type_collections = $job_images->groupBy('job_image_type_id');
        // Return the show view.
        return view('menu.quotes.quick.show')
            ->with([
                'selected_quote' => $selected_quote,
                'all_areas_to_be_treated_quote_tasks' => $all_areas_to_be_treated_quote_tasks,
                'all_additions_quote_tasks' => $all_additions_quote_tasks,
                'all_available_additions' => $all_available_additions,
                'all_other_works_quote_tasks' => $all_other_works_quote_tasks,
                'all_available_other_works' => $all_available_other_works,
                'staff_members' => $staff_members,
                'building_types' => $building_types,
                'building_styles' => $building_styles,
                'inspection_types' => $inspection_types,
                'job_types' => $job_types,
                'material_types' => $material_types,
                'all_rates' => $all_rates,
                'selected_job_types' => $selected_job_types,
                'image_types' => $image_types,
                'image_type_collections' => $image_type_collections,
                'all_default_additional_comments' => $all_default_additional_comments,
                'all_default_properties_to_view' => $all_default_properties_to_view,
                'fuel_product' => $fuel_product,
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
        /*
        |--------------------------------------------------------------------------
        | Find the selected action based on the form submitted.
        |--------------------------------------------------------------------------
        */

        switch ($request->action) {

            /*
            |--------------------------------------------------------------------------
            | Update the job form.
            |--------------------------------------------------------------------------
            */

            case 'update-job':

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
                    'job_types' => 'required',
                    'start_date' => 'sometimes|nullable|string|required_without:start_date_null',
                    'start_date_null' => 'sometimes|nullable|string|required_without:start_date',
                ]);

                // Find the required quote.
                $selected_quote = Quote::findOrFail($id); 

                // Find the required job.
                $selected_job = Job::find($selected_quote->job_id);

                // Update the selected job.
                $selected_job->update([
                    'salesperson_id' => $request->salesperson_id,
                    'tenant_name' => $request->tenant_name,
                    'tenant_home_phone' => $request->tenant_home_phone,
                    'tenant_street_address' => $request->tenant_street_address,
                    'tenant_suburb' => $request->tenant_suburb,
                    'tenant_postcode' => $request->tenant_postcode,
                    'material_type_id' => $request->material_type_id,
                    'building_style_id' => $request->building_style_id,
                    'building_type_id' => $request->building_type_id,
                    'start_date' => isset($request->start_date_null) ? null : Carbon::parse($request->start_date),
                    'start_date_null' => isset($request->start_date_null) ? 1 : 0,
                ]);

                // Update the job type model relationships.
                // Create pivot table entries with array of selected job types.
                $selected_job->job_types()->sync($request->job_types);

                // Create public note if required
                if (isset($request->public_message)) {
                    // Create new note
                    Note::create([
                        'sender_id' => Auth::id(),
                        'job_id' => $selected_job->id,
                        'priority_id' => 4,
                        'text' => $request->public_message . ' - ' . Auth::user()->getFullNameAttribute() . '.',
                        'recipient_id' => $selected_job->customer_id,
                        'jms_seen_at' => Carbon::now(),
                        'jms_acknowledged_at' => Carbon::now()
                    ]);
                    // Check if the selected quote customer has an email address.
                    if ($selected_job->customer->email != null) {
                        // Create the data array to populate the emails with.
                        $data = [
                            'recipient_name' => $selected_job->customer->getFullNameAttribute(),
                            'job_id' => $selected_job->id
                        ];
                        // Send the email.
                        Mail::to($selected_job->customer->email)
                            ->send(new NewJobNote($data));
                    }
                }

                // START DATE EVENT
                // Find the required event.
                $selected_event = Event::where('job_id', $selected_job->id)
                    ->firstOrFail();
                // Check if the start date null checkbox isset.
                if (isset($request->start_date_null)) {
                    // The start date null checkbox is checked.
                    // This needs to be set to 0 so the event will no longer appear in the user calendar and will appear in the unknown jobs for the user to assign a new start date at a later date.
                    $selected_event->update([
                        'is_tradesperson_confirmed' => 0
                    ]);
                } else {
                    // The start date null checkbox isset,
                    // Update the selected event.
                    $selected_event->update([
                        'start' => Carbon::parse($request->start_date),
                        'end' => Carbon::parse($request->start_date)->addHour(2), // Add 2 hours.
                        'quote_id' => $selected_quote->id,
                        'description' => 'The start date has been manually set via the quick quote update form by ' . Auth::user()->getFullNameAttribute(),
                    ]);
                }

                // ADDITIONAL SALESPERSONS
                // Check if the salesperson variable is null.
                if($request->salespersons == null) {
                    // There are no commissions selected.
                    // find all commissions.
                    $selected_commissions = QuoteCommission::where('quote_id', $id)->get();
                    // Loop through each of them.
                    foreach($selected_commissions as $commission) {
                        // Delete the selected commission.
                        $commission->delete();
                    }
                } else {

                    // Secondary validation.
                    // Get the count of all selected users that do not receive commissions. 
                    $users_without_commissions = User::whereIn('id', $request->salespersons)
                        ->where('has_commissions', 0)
                        ->count();
                    if ($users_without_commissions >= 1) {
                        return back()
                            ->with('danger', 'One or more of the selected quote salespersons is set to not receive commissions so you cannot create a commission for them. Please edit the commission status of the required user and try again.');
                    }

                    // Get the salesperson ids of all current commissions.
                    $current_commission_salesperson_ids = $selected_quote->commissions()->pluck('salesperson_id')->toArray();

                    // Loop through all supplied ids.
                    foreach($request->salespersons as $salesperson_id) {
                        // If the id is not in the array create it.
                        if(!in_array($salesperson_id, $current_commission_salesperson_ids)) {
                            // Create the item.
                            QuoteCommission::create([
                                'quote_id' => $id,
                                'salesperson_id' => $salesperson_id
                            ]);
                        }
                    }
                    // Loop through all current ids
                    foreach($current_commission_salesperson_ids as $salesperson_id) {
                        // If the id is not in the array create it.
                        if(!in_array($salesperson_id, $request->salespersons)) {
                            // Find the item. 
                            $selected_commission = QuoteCommission::where('quote_id', $id)
                                ->where('salesperson_id', $salesperson_id);
                                // Delete the commission item.
                            $selected_commission->delete();
                        }
                    }
                }
                // Update all commissions objects.
                $selected_quote->updateAllQuoteCommissions();

                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id)
                    ->with('success', 'You have successfully updated the selected job details.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Update quote description.
            |--------------------------------------------------------------------------
            */

            case 'update-quote-description':

                // Validate The Request Data.
                $request->validate([
                    'description' => 'sometimes|nullable|string|min:5|max:255'
                ]);
                // Find the required quote.
                $selected_quote = Quote::findOrFail($id);
                // Update the selected model instance.
                $selected_quote->update([
                    'description' => $request->description
                ]);
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#job-type-title')
                    ->with('success', 'You have successfully updated the quote description.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Update additional comments.
            |--------------------------------------------------------------------------
            */

            case 'update-additional-comments':

                // Validate The Request Data.
                $request->validate([
                    'additional_comments' => 'sometimes|nullable|string',
                    'default_additional_comment' => 'sometimes|nullable|string'
                ]);
                // Find the required quote.
                $selected_quote = Quote::findOrFail($id);
                // Check if the default additional comments dropdown has been set.
                if (isset($request->default_additional_comment)) {
                    // Find the required default additional comment.
                    $selected_default_additional_comment = DefaultAdditionalComment::find($request->default_additional_comment);
                    // Concatinate the selected default text to the end of the entered additional comments textarea.
                    $value = $request->additional_comments . ' ' . $selected_default_additional_comment->text;
                } else {
                    // Set the value to be only the entered text.
                    $value = $request->additional_comments;
                }
                // Update the selected quote.
                $selected_quote->update([
                    'additional_comments' => $value
                ]);
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#additional-comments-title')
                    ->with('success', 'You have successfully updated the additional comments.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Create new area to be treated.
            |--------------------------------------------------------------------------
            */

            case 'areas-to-be-treated-create':

                // Validate The Request Data.
                $request->validate([
                    'building_style_id' => 'required',
                    'building_type_id' => 'required',
                    'material_type_id' => 'required',
                    'roof_area' => 'required|numeric',
                    'roof_pitch' => 'required|numeric|min:0|max:65|digits_between:1,2'
                ]);

                // Set The Required Variables.
                // Find the required quote.
                $selected_quote = Quote::findOrFail($id);
                // Find selected model instance.
                $selected_task = Task::where('building_style_id', $request->building_style_id)
                    ->where('building_type_id', $request->building_type_id)
                    ->where('material_type_id', $request->material_type_id)
                    ->firstOrFail();

                // CALCULATE ROOF PITCH
                // Convert entered roof pitch to nearest whole integer.
                $roof_pitch = ceil($request->roof_pitch);
                // Convert number to ineger.
                $roof_pitch = intval($roof_pitch);
                // Check if the roof pitch is 0 or greater than 65.
                if ($roof_pitch == 0 || $roof_pitch >= 66) {
                    // The value is outside of the allowed values.
                    // Set the roof pitch multiply factor to 1.
                    $roof_pitch_multiply_factor = 1;
                } else {
                    // The entered value is inside of the allowed values.
                    // Set all possible values.
                    $all_roof_pitch_multiply_factors = RoofPitchMultiplyFactor::all();
                    // Loop through each roof pitch multiply factor.
                    foreach($all_roof_pitch_multiply_factors as $multiply_factor) {
                        // Set min value.
                        $min = $multiply_factor->min;
                        // Set max value.
                        $max = $multiply_factor->max;
                        // Check if the entered value is within the selected min max range.
                        if ($roof_pitch >= $min && $roof_pitch <= $max) {
                            // The entered value is within the range so set the price.
                            $roof_pitch_multiply_factor = $multiply_factor->value;
                        }
                    }
                }

                // TASK PRICE RANGE
                // Check the quantity value.
                $entered_value = $request->roof_area;
                // Check if the entered value is greater than 20.
                if ($entered_value <= 19) {
                    // The entered value is less than 20 so do nothing.
                    $range_filtered_price = $selected_task->price;
                } else {
                    // The entered value is more than 20 so find the price in the task price range.
                    // All task price ranges
                    $all_task_price_ranges = TaskPriceRange::all();
                    // Loop through each task price range.
                    foreach($all_task_price_ranges as $task_price_range) {
                        // Set min value.
                        $min = $task_price_range->min;
                        // Set max value.
                        $max = $task_price_range->max;
                        // Check if the entered value is within the selected min max range.
                        if ($entered_value >= $min && $entered_value <= $max) {
                            // The entered value is within the range so set the price.
                            $range_filtered_price = $task_price_range->price;
                        }
                    }
                }

                // TOTAL ROOF AREA
                // Multiply the entered quantity with the roof pitch multiply factor, then round up to the nearest integer.
                $total_roof_area = ceil($request->roof_area * $roof_pitch_multiply_factor);
                // Remove decimal place and cast to integer.
                $total_roof_area = intval($total_roof_area);

                // BUILDING STYLE SURCHARGE
                // Check if the task is double or single.
                if ($selected_task->building_style_id == 1) { // Single Storey.
                    // Single storey.
                    // Set individual price.
                    $task_individual_price = $range_filtered_price;
                    // Set total price.
                    $total_price = $total_roof_area * $range_filtered_price;
                } else {
                    // Not single storey.
                    // Get the double storey surcharge value.
                    $surcharge_value = DoubleStoreySurcharge::first();
                    // Sum the range filtered price and the surcharge value.
                    $task_individual_price = $range_filtered_price + $surcharge_value->price;
                    // Total price.
                    $total_price = $total_roof_area * $task_individual_price;
                }

                // QUOTE TASK
                // Create a new quote task.
                QuoteTask::create([
                    'quote_id' => $selected_quote->id,
                    'task_id' => $selected_task->id,
                    'quantity' => $request->roof_area,
                    'total_quantity' => $total_roof_area,
                    'pitch' => $request->roof_pitch,
                    'individual_price' => $task_individual_price,
                    'total_price' => $total_price,
                ]);

                // SET MPA COVERAGE
                // Find all of the required quote tasks and pluck the task_id to an array.
                $all_task_ids = QuoteTask::where('quote_id', $selected_quote->id)
                    ->pluck('task_id')
                    ->toArray();
                // Find all of the required tasks and pluck the material types to an array.
                $task_material_type_ids = Task::find($all_task_ids)
                    ->pluck('material_type_id')
                    ->toArray();
                // Find the material type that has the largest mpa coverage.
                $selected_mpa_coverage = MaterialType::whereIn('id', $task_material_type_ids)
                    ->max('mpa_coverage');
                // Update the selected quote.
                $selected_quote->update([
                    'mpa_coverage' => $selected_mpa_coverage ?? 1 // Set the found value or set to the default of 1.
                ]);

                // Update the tradepserson product total.
                $selected_quote->updateQuoteProductTradespersonMaterials();

                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#areas-to-be-treated-title')
                    ->with('success', 'You have successfully created a new area to be treated.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Update an area to be treated.
            |--------------------------------------------------------------------------
            */

            case 'areas-to-be-treated-update':

                // Validate The Request Data.
                $request->validate([
                    'areas_to_be_treated_edit_quantity' => 'required|numeric',
                    'areas_to_be_treated_edit_roof_pitch' => 'required|numeric|min:0|max:65|digits_between:1,2'
                ]);

                // Set The Required Variables.
                // Find the required quote task.
                $selected_task = QuoteTask::findOrFail($request->quote_task_id);

                // CALCULATE ROOF PITCH
                // Convert entered roof pitch to nearest whole integer.
                $roof_pitch = ceil($request->areas_to_be_treated_edit_roof_pitch);
                // Convert number to ineger.
                $roof_pitch = intval($roof_pitch);
                // Check if the roof pitch is 0 or greater than 65.
                if ($roof_pitch == 0 || $roof_pitch >= 66) {
                    // The value is outside of the allowed values.
                    // Set the roof pitch multiply factor to 1.
                    $roof_pitch_multiply_factor = 1;
                } else {
                    // The entered value is inside of the allowed values.
                    // Set all possible values.
                    $all_roof_pitch_multiply_factors = RoofPitchMultiplyFactor::all();
                    // Loop through each roof pitch multiply factor.
                    foreach($all_roof_pitch_multiply_factors as $multiply_factor) {
                        // Set min value.
                        $min = $multiply_factor->min;
                        // Set max value.
                        $max = $multiply_factor->max;
                        // Check if the entered value is within the selected min max range.
                        if ($roof_pitch >= $min && $roof_pitch <= $max) {
                            // The entered value is within the range so set the price.
                            $roof_pitch_multiply_factor = $multiply_factor->value;
                        }
                    }
                }

                // TASK PRICE RANGE
                // Check the quantity value.
                $entered_value = $request->areas_to_be_treated_edit_quantity;
                // Check if the entered value is greater than 20.
                if ($entered_value <= 19) {
                    // The entered value is less than 20 so do nothing.
                    $range_filtered_price = $selected_task->price;
                } else {
                    // The entered value is more than 20 so find the price in the task price range.
                    // All task price ranges
                    $all_task_price_ranges = TaskPriceRange::all();
                    // Loop through each task price range.
                    foreach($all_task_price_ranges as $task_price_range) {
                        // Set min value.
                        $min = $task_price_range->min;
                        // Set max value.
                        $max = $task_price_range->max;
                        // Check if the entered value is within the selected min max range.
                        if ($entered_value >= $min && $entered_value <= $max) {
                            // The entered value is within the range so set the price.
                            $range_filtered_price = $task_price_range->price;
                        }
                    }
                }

                // TOTAL ROOF AREA
                // Multiply the entered quantity with the roof pitch multiply factor, then round up to the nearest integer.
                $total_roof_area = ceil($request->areas_to_be_treated_edit_quantity * $roof_pitch_multiply_factor);
                // Remove decimal place and cast to integer.
                $total_roof_area = intval($total_roof_area);

                // BUILDING STYLE SURCHARGE
                // Check if the task is double or single.
                if ($selected_task->task->building_style_id == 1) { // Single Storey.
                    // Single storey.
                    // Set individual price.
                    $task_individual_price = $range_filtered_price;
                    // Set total price.
                    $total_price = $total_roof_area * $range_filtered_price;
                } else {
                    // Not single storey.
                    // Get the double storey surcharge value.
                    $surcharge_value = DoubleStoreySurcharge::first();
                    // Sum the range filtered price and the surcharge value.
                    $task_individual_price = $range_filtered_price + $surcharge_value->price;
                    // Total price.
                    $total_price = $total_roof_area * $task_individual_price;
                }

                // UPDATE THE SELECTED MODEL INSTANCE
                $selected_task->quantity = $request->areas_to_be_treated_edit_quantity;
                $selected_task->total_quantity = $total_roof_area; // This is the quantity with the pitch factored in.
                $selected_task->pitch = $request->areas_to_be_treated_edit_roof_pitch;
                $selected_task->individual_price = $task_individual_price;
                $selected_task->total_price = $total_price;
                $selected_task->save();

                // QUOTE
                // Find the required quote.
                $selected_quote = Quote::findOrFail($id);

                // SET MPA COVERAGE
                // Find all of the required quote tasks and pluck the task_id to an array.
                $all_task_ids = QuoteTask::where('quote_id', $selected_quote->id)
                    ->pluck('task_id')
                    ->toArray();
                // Find all of the required tasks and pluck the material types to an array.
                $task_material_type_ids = Task::find($all_task_ids)
                    ->pluck('material_type_id')
                    ->toArray();
                // Find the material type that has the largest mpa coverage.
                $selected_mpa_coverage = MaterialType::whereIn('id', $task_material_type_ids)
                    ->max('mpa_coverage');
                // Update the selected quote.
                $selected_quote->update([
                    'mpa_coverage' => $selected_mpa_coverage ?? 1 // Set the found value or set to the default of 1.
                ]);

                // Update the tradepserson product total.
                $selected_quote->updateQuoteProductTradespersonMaterials();

                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#areas-to-be-treated-title')
                    ->with('success', 'You have successfully updated the selected area to be treated.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Delete an area to be treated.
            |--------------------------------------------------------------------------
            */

            case 'areas-to-be-treated-delete':

                // Set The Required Variables.
                // Find the required quote task.
                $selected_quote_task = QuoteTask::find($request->quote_task_id);
                // Find the required quote.
                $selected_quote = Quote::findOrFail($id);
                // Delete the selected quote task.
                $selected_quote_task->delete();
                // SET MPA COVERAGE
                // Find all of the required quote tasks and pluck the task_id to an array.
                $all_task_ids = QuoteTask::where('quote_id', $selected_quote->id)
                    ->pluck('task_id')
                    ->toArray();
                // Find all of the required tasks and pluck the material types to an array.
                $task_material_type_ids = Task::find($all_task_ids)
                    ->pluck('material_type_id')
                    ->toArray();
                // Find the material type that has the largest mpa coverage.
                $selected_mpa_coverage = MaterialType::whereIn('id', $task_material_type_ids)
                    ->max('mpa_coverage');
                // Update the selected quote.
                $selected_quote->update([
                    'mpa_coverage' => $selected_mpa_coverage ?? 1 // Set the found value or set to the default of 1.
                ]);
                // Update the tradepserson product total.
                $selected_quote->updateQuoteProductTradespersonMaterials();
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#areas-to-be-treated-title')
                    ->with('success', 'You have successfully deleted the selected area to be treated.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Create new action.
            |--------------------------------------------------------------------------
            */

            case 'additions-create':

                // Validate The Request Data.
                $request->validate([
                    'addition_id' => 'required',
                    'quantity' => 'required',
                ]);
                // Set The Required Variables.
                // Find the required task.
                $selected_task = Task::findOrFail($request->addition_id);
                // Create a new quote task.
                $new_quote_task = QuoteTask::create([
                    'quote_id' => $id,
                    'task_id' => $selected_task->id,
                    'quantity' => $request->quantity,
                    'total_quantity' => $request->quantity,
                    'pitch' => 0,
                    'individual_price' => $selected_task->price,
                    'total_price' => $request->quantity * $selected_task->price,
                ]);
                // Update the tradepserson product total.
                $new_quote_task->quote->updateQuoteProductTradespersonMaterials();
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#additions-title')
                    ->with('success', 'You have successfully created a new addition.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Delete an action.
            |--------------------------------------------------------------------------
            */

            case 'additions-delete':

                // Set The Required Variables.
                // Find the required quote.
                $selected_quote = Quote::findOrFail($id);
                // Find the required quote task.
                $selected_task = QuoteTask::find($request->quote_task_id);
                // Delete The Selected Quote Task.
                $selected_task->delete();
                // Update the tradepserson product total.
                $selected_quote->updateQuoteProductTradespersonMaterials();
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#additions-title')
                    ->with('success', 'You have successfully deleted the selected addition.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Update default properties.
            |--------------------------------------------------------------------------
            */

            case 'update-default-properties':

                // Validate The Request Data.
                $request->validate([
                    'default_properties_to_view' => 'required|integer',
                ]);
                // Find the required quote.
                $selected_quote = Quote::findOrFail($id);
                // Find the required job.
                $selected_job = Job::find($selected_quote->job_id);
                // Save the selected job.
                $selected_job->update([
                    'default_properties_to_view_id' => $request->default_properties_to_view
                ]);
                // Find the required default properties to view.
                $selected_default_properties_to_view = DefaultPropertiesToView::find($request->default_properties_to_view);
                // Update the selected model instance.
                $selected_default_properties_to_view->update([
                    'is_delible' => 0 
                ]);
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#default-properties-to-view-title')
                    ->with('success', 'You have successfully updated the default properties to view.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Create new other works.
            |--------------------------------------------------------------------------
            */

            case 'other-works-create':

                // Validate The Request Data.
                $request->validate([
                    'other_work_id' => 'required',
                ]);
                // Set The Required Variables.
                // Find the required task.
                $selected_task = Task::findOrFail($request->other_work_id);
                // Create a new quote task.
                $new_quote_task = QuoteTask::create([
                    'quote_id' => $id,
                    'task_id' => $selected_task->id,
                    'quantity' => 1,
                    'total_quantity' => 1,
                    'pitch' => 0,
                    'individual_price' => $selected_task->price,
                    'total_price' => $selected_task->price,
                ]);
                // Update the tradepserson product total.
                $new_quote_task->quote->updateQuoteProductTradespersonMaterials();
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#other-works-title')
                    ->with('success', 'You have successfully created a new other works.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Delete an other works.
            |--------------------------------------------------------------------------
            */

            case 'other-works-delete':

                // Set The Required Variables.
                // Find the required quote.
                $selected_quote = Quote::findOrFail($id);
                // Find the required quote task.
                $selected_task = QuoteTask::find($request->quote_task_id);
                // Delete the selected quote task.
                $selected_task->delete();
                // Update the tradepserson product total.
                $selected_quote->updateQuoteProductTradespersonMaterials();
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#other-works-title')
                    ->with('success', 'You have successfully deleted the selected other works.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Create new rate.
            |--------------------------------------------------------------------------
            */

            case 'rates-create':

                // Validate The Request Data.
                $request->validate([
                    'tradesperson_new_rate_id' => 'required',
                ]);
                // Set The Required Variables.
                // Find the required rate.
                $selected_rate = Rate::findOrFail($request->tradesperson_new_rate_id);
                // Set the required quantity, if none entered set to 1 by default.
                $entered_quantity = $request->tradesperson_rate_new_quantity ?? 1;
                // Create a new quote rate.
                QuoteRate::create([
                    'quote_id' => $id,
                    'rate_id' => $selected_rate->id,
                    'quantity' => $entered_quantity,
                    'individual_price' => $selected_rate->price,
                    'total_price' => $selected_rate->price * $entered_quantity,
                ]);
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#rates-title')
                    ->with('success', 'You have successfully created a new other works.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Update selected rate.
            |--------------------------------------------------------------------------
            */

            case 'rates-update':

                // Validate The Request Data.
                $request->validate([
                    'tradesperson_rate_update_quantity' => 'required',
                ]);
                // Set The Required Variables.
                // Find the required quote rate.
                $selected_quote_rate = QuoteRate::find($request->quote_rate_id);
                // Update the selected quote rate.
                $selected_quote_rate->update([
                    'quantity' => $request->tradesperson_rate_update_quantity ?? 1,
                    'individual_price' => $selected_quote_rate->rate->price,
                    'total_price' => $selected_quote_rate->rate->price  * $selected_quote_rate->quantity,
                ]);
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#rates-title')
                    ->with('success', 'You have successfully created a new other works.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Delete a rate.
            |--------------------------------------------------------------------------
            */

            case 'rates-delete':

                // Set The Required Variables.
                // Find the required quote task.
                $selected_rate = QuoteRate::find($request->quote_rate_id);
                // Delete the selected quote task.
                $selected_rate->delete();
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#rates-title')
                    ->with('success', 'You have successfully deleted the selected rate.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Update the job type.
            |--------------------------------------------------------------------------
            */

            case 'update-quote-job-type':

                // Validate The Request Data.
                $request->validate([
                    'job_type_id' => 'required',
                ]);
                // Set The Required Variables.
                // Find the required quote.
                $selected_quote = Quote::findOrFail($id);
                // Update the selected quote.
                $selected_quote->update([
                    'job_type_id' => $request->job_type_id
                ]);
                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#job-type-title')
                    ->with('success', 'You have successfully updated the quote job type.');

            break;

            /*
            |--------------------------------------------------------------------------
            | Create new fuel product.
            |--------------------------------------------------------------------------
            */

            case 'fuel-update':

                // Validate The Request Data.
                $request->validate([
                    'travel_distance' => 'required|integer',
                ]);
                // Set The Required Variables.
                // Find the required rate.
                $selected_quote_product = QuoteProduct::where('quote_id', $id)->where('product_id', 6)->first();
                // Create new fuel product item.
                $selected_system = System::firstOrFail(); // Moss Roof Treatment.

                // Create the required variables.
                $default_petrol_price = $selected_system->default_petrol_price;
                // The amount of petrol used to travel 100km (double 12.0).
                $default_litres_per_km = $selected_system->default_petrol_usage;
                // The distance to travel.
                $distance = intval($request->travel_distance);
                // Perform the equasion. Fuel cost = (Distance / 100 × Consumption) × Cost per litre.
                $calculated_price = ($distance / 100 * $default_litres_per_km) * $default_petrol_price;
                // Create a new quote rate.
                $selected_quote_product->update([
                    'quantity' => $distance,
                    'individual_price' => number_format(($selected_system->default_petrol_price / 100), 2, '.'), // Double value converted to int.
                    'total_price' => intval($calculated_price), // Double value converted to int.
                    'price_per_litre' => $default_petrol_price, // Int.
                    'usage_per_100_kms' => $default_litres_per_km, // Double.
                ]);

                // Return a redirect to the show route.
                return redirect()
                    ->route('quick-quote.show', $id . '#fuel-calculations-title')
                    ->with('success', 'You have successfully updated the fuel calculation.');

            break;

            default:

                // Return a redirect to the show route.
                return redirect()
                    ->route('main-menu.index');
        }
    }
}
