<?php

namespace App\Http\Controllers\Menu\Customer;

use App\Http\Controllers\Controller;
use App\Models\AccountClass;
use App\Models\Lead;
use App\Models\LeadContact;
use App\Models\LeadStatus;
use App\Models\Referral;
use App\Models\State;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class LeadController extends Controller
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
        // Find all of the required model instances.
        $all_leads = Lead::with('lead_contacts', 'account_class')
            ->get();
        // Return the index view.
        return view('menu.customers.leads.index')
            ->with('all_leads', $all_leads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // Find all customer account classes.
        $all_account_classes = AccountClass::whereNotBetween('id', [1, 2]) // Only non staff account classes.
            ->select('id', 'title')
            ->withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // Find all states.
        $all_states = State::all('id', 'title');
        // Find all referrals.
        $all_referrals = Referral::withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // Return the index view.
        return view('menu.customers.leads.create')
            ->with([
                'all_states' => $all_states,
                'all_referrals' => $all_referrals,
                'all_account_classes' => $all_account_classes
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
            'account_class_id' => 'sometimes|nullable',
            'email' => 'sometimes|nullable|unique:leads,email',
            'first_name' => 'sometimes|nullable|string|min:3|max:50',
            'last_name' => 'sometimes|nullable|string|min:3|max:50',
            'street_address' => 'required|string|min:8|max:100',
            'suburb' => 'required|string|min:3|max:60',
            'postcode' => 'required|numeric|min:1000|max:9999',
            'state_id' => 'required',
            'referral_id' => 'required',
            'home_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:mobile_phone',
            'mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:home_phone',
            'business_name' => 'nullable|string',
            'abn' => 'nullable|numeric',
            'business_phone' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image_path' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);

        // Create the new model instance.
        $lead = Lead::create([
            'account_class_id' => $request->account_class_id ?? 5, // Default - Individual.
            'staff_id' => Auth::id(),
            'referral_id' => $request->referral_id ?? 1, // Default - Yellow Pages.
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'street_address' => $request->street_address,
            'suburb' => $request->suburb,
            'state_id' => $request->state_id,
            'postcode' => $request->postcode,
            'home_phone' => str_replace(' ', '', $request->home_phone),
            'mobile_phone' => str_replace(' ', '', $request->mobile_phone),
            'business_name' => $request->business_name,
            'business_phone' => $request->business_phone,
            'abn' => $request->abn,
            'description' => $request->description,
        ]);

        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/leads/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->toJpeg(80)->save($location);
            // Update the selected model instance.
            $lead->update([
                'image_path' => 'storage/images/leads/' . $filename
            ]);
        }

        // Return a redirect to the show route.
        return redirect()
            ->route('leads.show', $lead->id)
            ->with('success', 'You have successfully created a new customer lead.');
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
        $lead = Lead::findOrFail($id);
        // Set The Required Variables.
        // Find all customer account classes.
        $all_account_classes = AccountClass::whereNotBetween('id', [1, 2]) // Only non staff account classes.
            ->select('id', 'title')
            ->withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // Find all lead contacts.
        $lead_contacts = LeadContact::where('lead_id', $id)
            ->orderBy('call_back_date', 'desc')
            ->get();
        // Find all referrals.
        $all_referrals = Referral::withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // Find all referrals.
        $all_lead_statuses = LeadStatus::all();
        // Find all states.
        $all_states = State::all('id', 'title');
        // Return the show view.
        return view('menu.customers.leads.show')
            ->with([
                'lead' => $lead,
                'lead_contacts' => $lead_contacts,
                'all_referrals' => $all_referrals,
                'all_lead_statuses' => $all_lead_statuses,
                'all_states' => $all_states,
                'all_account_classes' => $all_account_classes
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
            'account_class_id' => 'sometimes|nullable',
            'email' => 'sometimes|nullable|unique:leads,email,' . $id,
            'first_name' => 'sometimes|nullable|string|min:3|max:50',
            'last_name' => 'sometimes|nullable|string|min:3|max:50',
            'street_address' => 'required|string|min:8|max:100',
            'suburb' => 'required|string|min:3|max:60',
            'postcode' => 'required|numeric|min:1000|max:9999',
            'state' => 'required|string',
            'referral_id' => 'required|string',
            'lead_status_id' => 'required',
            'home_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:mobile_phone',
            'mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:home_phone',
            'business_name' => 'nullable|string',
            'abn' => 'nullable|numeric',
            'business_phone' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image_path' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Find the required model instance.
        $lead = Lead::findOrFail($id);
        // Update the selected model instance.
        $lead->update([
            'account_class_id' => $request->account_class_id ?? 5, // Default - Individual.
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'street_address' => $request->street_address,
            'suburb' => $request->suburb,
            'state_id' => $request->state,
            'referral_id' => $request->referral_id,
            'lead_status_id' => $request->lead_status_id,
            'postcode' => $request->postcode,
            'home_phone' => str_replace(' ', '', $request->home_phone),
            'mobile_phone' => str_replace(' ', '', $request->mobile_phone),
            'business_name' => $request->business_name,
            'business_phone' => $request->business_phone,
            'abn' => $request->abn,
            'description' => $request->description
        ]);

        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Check if the file path value is not null and file exists on the server.
            if ($lead->image_path != null && file_exists(public_path($lead->image_path))) {
                // Delete the file from the server.
                unlink(public_path($lead->image_path));
            }
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/leads/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->toJpeg(80)->save($location);
            // Update the selected model instance.
            $lead->update([
                'image_path' => 'storage/images/leads/' . $filename
            ]);
        }

        // Return the show view.
        return redirect()
            ->route('leads.show', $id)
            ->with('success', 'You have successfully updated the selected customer lead.');
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
        $lead = Lead::findOrFail($id);
        // Delete the selected model instance relationships.
        $lead->lead_contacts()->delete();
        // Check if the file path value is not null and file exists on the server.
        if ($lead->image_path != null && file_exists(public_path($lead->image_path))) {
            // Delete the file from the server.
            unlink(public_path($lead->image_path));
        }
        // Delete the selected model instance.
        $lead->delete();
        // Return redirect to the index route.
        return redirect()
            ->route('leads.index')
            ->with('success', 'You have successfully deleted the selected customer lead.');
    }
}
