<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\Event;
use App\Models\Job;
use App\Mail\Customer\TradespersonAssigned;
use App\Mail\Staff\StaffNewFlag;
use App\Models\Note;
use App\Models\Quote;
use App\Models\QuoteRate;
use App\Models\QuoteUser;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class FlagController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Validation.
        // Check if the required GET variable has not been supplied in the URL.
        if (!isset($_GET['selected_job_id'])) {
            // The Get variable was not supplied in the URL.
            // Return a 404.
            return abort(404);
        }

        $selected_job = Job::findOrFail($_GET['selected_job_id']);

        $all_quote_ids = Quote::where('job_id', $selected_job->id)
            ->pluck('id')
            ->toArray();

        // All selected quote rates.
        $all_quote_rates = QuoteRate::whereIn('quote_id', $all_quote_ids)
            ->where('staff_id', null)
            ->get();

        // All tradespersons.
        $all_users = User::where('account_role_id', 3) // 3 = Tradesperson.
            ->with('account_role')
            ->get();

        // EMAIL
        // Set the email template.
        $selected_email_template = EmailTemplate::find(10); // Tradesperson Assigned.

        return view('menu.jobs.flags.create')
            ->with([
                'selected_job' => $selected_job,
                'all_users' => $all_users,
                'all_quote_rates' => $all_quote_rates,
                'selected_email_template' => $selected_email_template
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
            'flag_id' => 'required',
            'quote_id' => 'required',
            'quote_rate_id' => 'required',
            'optional_message' => 'sometimes|nullable|string|min:10|max:1000',
        ]);

        // Secondary validation
        // Check if there is already a quote user pivot table relationsshipl.
        $selected_job_flag = QuoteUser::where('tradesperson_id', $request->flag_id)
            ->where('quote_id', $request->quote_id)
            ->first();
        // Check if the selected job flag already exists in the database.
        if ($selected_job_flag != null) {
            // Return a redirect back with message.
            return back()->with('warning', 'The selected job flag you are attempting to create already exists, Please select another job flag.');
        }

        // Set The Required Variables.
        // Find the seleced staff member.
        $selected_tradesperson = User::findOrFail($request->flag_id);
        // Set the selected job id.
        $selected_job = Job::find($request->selected_job_id);
        // Set the selected quote id.
        $selected_quote = Quote::find($request->quote_id);
        // Set the customer.
        $selected_customer = User::find($selected_job->customer_id);
        // Find the required calendar event.
        $selected_event = Event::where('job_id', $selected_job->id)->first();

        // Create the QuoteUser.
        // Create the new quote user pivot table.
        QuoteUser::create([
            'quote_id' => $selected_quote->id,
            'tradesperson_id' => $selected_tradesperson->id,
            'optional_message' => $request->optional_message
        ]);
        // Find all the entered rates.
        $selected_rates = QuoteRate::findOrFail($request->quote_rate_id);
        // QUOTE RATES
        // Loop through each quote rate and assign the selected tradesperson.
        foreach($selected_rates as $selected_rate) {
            // Set the user id of each selected rate.
            $selected_rate->update([
                'staff_id' => $selected_tradesperson->id
            ]);
        }
        // CALENDAR EVENT
        // Check if the selected tradesperson has a logo image uploaded.
        if ($selected_tradesperson->logo_path != null) {
            $selected_event->update([
                // Insert the image into the selected event.
                'image_paths' => $selected_event->image_paths . '<img src="' . url($selected_tradesperson->logo_path) . '" ' . 'style="width:25px; height:25px; padding-left:3px;' .  '">'
            ]);
        }
        // Check if the optional message is not null.
        if ($request->optional_message != null) {
            // Create the note if required.
            Note::create([
                'job_id' => $selected_job->id,
                'sender_id' => Auth::id(),
                'text' => $request->optional_message . ' - ' . Auth::user()->getFullNameAttribute() . '.',
                'is_internal' => 1, // Is internal.
                'priority_id' => 4, // Low.
                'recipient_id' => $selected_tradesperson->id,
                'jms_seen_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
                'jms_acknowledged_at' => in_array(auth()->user()->account_role_id, [1,2]) ? now() : null,
            ]);
        }
        // TRADESPERSON JOB FLAG EMAIL
        // Create the data array for the notification.
        $data = [
            'id' => $selected_quote->id,
            'recipient_name' => $selected_tradesperson->getFullNameAttribute(),
            'quote_identifier' => $selected_quote->quote_identifier
        ];
        // Send the email.
        Mail::to($selected_tradesperson->email)
            ->send(new StaffNewFlag($data));

        // CUSTOMER TRADESPERSON ASSIGNED EMAIL
        // Check if the send to customer checkbox is checked and if the customer has an email address.
        if ($request->send_email_to_customer != null && $selected_job->customer->email != null) {
            // Make data variable.
            $data = [
                'recipient_name' => $selected_customer->getFullNameAttribute(),
                'job_address' => $selected_job->tenant_street_address . ', ' . $selected_job->tenant_suburb . ', ' . $selected_job->tenant_postcode,
                'tradesperson_name' => $selected_tradesperson->getFullNameAttribute(),
                'subject' => $request->subject,
                'text' => $request->message
            ];
            // Send the email.
            Mail::to($selected_customer->email)
                ->send(new TradespersonAssigned($data));
            // Create tradesperson assigned email note.
            Note::create([
                'job_id' => $selected_job->id,
                'text' => '"Tradesperson Assigned" email for ' . $selected_tradesperson->getFullNameAttribute() . ' sent to customer. -' . Auth::user()->getFullNameAttribute(),
                'is_internal' => 1,
                'jms_seen_at' => now(),
                'jms_acknowledged_at' => now(),
            ]);
        }

        // Return a redirect to the index route.
        return redirect()
            ->route('jobs.show', $selected_job->id)
            ->with('success', 'You have successfully create the selected job flag.');
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
        $selected_quote_user = QuoteUser::findOrFail($id);
        // Return the show view.
        return view('menu.jobs.flags.show')
            ->with('selected_quote_user', $selected_quote_user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Set The Required Variables.
        // Find the required job flag.
        $selected_quote_user = QuoteUser::findOrFail($id);
        // Set the required quote id.
        $selected_quote = Quote::find($selected_quote_user->quote_id);
        // Find the required job.
        $selected_job = Job::find($selected_quote->job_id);
        // Find the required event.
        $selected_event = Event::where('job_id', $selected_job->id)
            ->first();
        // Find all requited quote rates.
        $selected_quote_rates = QuoteRate::where('quote_id', $selected_quote->id)
            ->where('staff_id', $selected_quote_user->tradesperson_id)
            ->get();
        // Loop through each selected quote rate.
        foreach($selected_quote_rates as $quote_rate) {
            // Set staff id to null.
            $quote_rate->update([
                'staff_id' => null
            ]);
        }
        // delete the selected quote user.
        $selected_quote_user->delete();
        // Update the required event model relationship.
        $selected_event->update([
            'image_paths' => null
        ]);
        // Get all quote tradespersons with the required quote id.
        $all_quote_tradesperson_ids = QuoteUser::where('quote_id', $selected_quote->id)
            ->pluck('tradesperson_id')
            ->toArray();
        // Check if the selected quote rate staff ids is not null.
        if ($all_quote_tradesperson_ids != null) {
            // Find all users from the staff id's array.
            $users = User::where('id', $all_quote_tradesperson_ids)->get();
            // Check if the users variable is not null. 
            if ($users != null) {
                // Loop through each user and insert their image.
                foreach($users as $user) {
                    // Check if the selected user has a logo image uploaded.
                    if ($user->logo_path != null) {
                        // Insert the image into the selected event.
                        $selected_event->image_paths = $selected_event->image_paths . '<img src="' . url($user->logo_path) . '" ' . 'style="width:25px; height:25px; padding-left:3px;' .  '">';
                        $selected_event->save();
                    }
                }
            }
        }
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully deleted the selected job flag.');
    }
}
