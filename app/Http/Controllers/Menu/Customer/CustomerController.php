<?php

namespace App\Http\Controllers\Menu\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountClass;
use App\Models\AccountRole;
use App\Models\Job;
use App\Models\LoginStatus;
use App\Models\Referral;
use App\Models\State;
use App\Models\System;
use App\Models\User;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CustomerController extends Controller
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
        // Return the index view.
        return view('menu.customers.index');
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
        // Find all referrals
        $all_referrals = Referral::withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // Find all states.
        $all_states = State::all('id', 'title');
        // Return the create view.
        return view('menu.customers.create')
            ->with([
                'all_account_classes' => $all_account_classes,
                'all_referrals' => $all_referrals,
                'all_states' => $all_states
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
            'username' => 'sometimes|nullable|min:7|max:100|required_without:email|unique:users,username',
            'email' => 'sometimes|nullable|min:7|max:100|required_without:username|unique:users,email',
            'password' => 'required|string|min:8|required_with:password_confirmation|confirmed',
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'street_address' => 'required|string|min:8|max:100',
            'suburb' => 'required|string|min:3|max:60',
            'postcode' => 'required|numeric|min:1000|max:9999',
            'state_id' => 'required',
            'home_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:mobile_phone',
            'mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:home_phone',
            'referral_id' => 'sometimes|nullable',
            'account_class_id' => 'sometimes|nullable',
            'business_name' => 'sometimes|nullable|string|max:100',
            'abn' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_contact_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_position' => 'sometimes|nullable|string|max:100',
            'bank_name' => 'sometimes|nullable|string|max:100',
            'bank_bsb' => 'sometimes|nullable',
            'bank_account_name' => 'sometimes|nullable|string|max:100',
            'bank_account_number' => 'sometimes|nullable',
            'business_description' => 'sometimes|nullable|string|max:255',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'logo' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);

        // Create the new model instance.
        $new_user = User::create([
            // MODEL RELATIONSHIPS
            'account_class_id' => $request->account_class_id ?? 5, // Default - Individual.
            'referral_id' => $request->referral_id ?? 7,  // Default - Not Registered.
            // STANDARD USER DETAILS
            'username' => $request->username == null ? $request->email : $request->username,
            'email' => $request->email == null ? null : $request->email,
            'password' => bcrypt($request->password),
            'first_name' => ucwords($request->first_name),
            'last_name' => ucwords($request->last_name),
            'street_address' => ucwords($request->street_address),
            'suburb' => ucwords($request->suburb),
            'state_id' => $request->state_id,
            'postcode' => $request->postcode,
            'home_phone' => str_replace(' ', '', $request->home_phone),
            'mobile_phone' => str_replace(' ', '', $request->mobile_phone),
            'user_description' => ucfirst($request->user_description),
            // OPTIONAL USER BUSINESS DETAILS
            'business_name' => ucwords($request->business_name),
            'abn' => str_replace(' ', '', $request->abn),
            'business_phone' => str_replace(' ', '', $request->business_phone),
            'business_contact_phone' => str_replace(' ', '', $request->business_contact_phone),
            'business_position' => ucwords($request->business_position),
            'bank_name' => ucwords($request->bank_name),
            'bank_bsb' => str_replace('-', '', $request->bank_bsb),
            'bank_account_name' => ucwords($request->bank_account_name),
            'bank_account_number' => $request->bank_account_number,
            'business_description' => ucfirst($request->business_description),
        ]);
        // DISPLAY IMAGE
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/customerImages/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $new_user->update([
                'image_path' => 'storage/images/customerImages/' . $filename
            ]);
        }
        // LOGO
        // Check the request data for the required file.
        if ($request->hasFile('logo')) {
            // Set the uploaded file.
            $image = $request->file('logo');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/customerLogos/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $new_user->update([
                'logo_path' => 'storage/images/customerLogos/' . $filename
            ]);
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('customers.show', $new_user->id)
            ->with('success', 'You have successfully created a new customer.');
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
        $selected_customer = User::findOrFail($id);
        // Secondary validation.
        // Check that the selected user has the required account role to be viewed.
        if ($selected_customer->account_role_id != 5) { // Customer
            // The selected user has the incorrect account role.
            // Return a redirect back.
            return back()
                ->with('danger', 'The selected user does not have the required account role to view them on the customer show page.');
        }
        // Set The Required Variables.
        // Find all customer account classes.
        $all_account_classes = AccountClass::whereNotBetween('id', [1, 2]) // Only non staff account classes.
            ->select('id', 'title')
            ->withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // Find all the account roles.
        $all_account_roles = AccountRole::orderBy('id', 'desc')->get();
        // Find all the login statuses.
        $all_login_statuses = LoginStatus::all('id', 'title');
        // Find all the jobs.
        $customer_jobs = Job::where('customer_id', $id)->get();
        // Find all the referrals.
        $all_referrals = Referral::withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // Find all the states.
        $all_states = State::all('id', 'title');
        // Get the System information.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Return the show route.
        return view('menu.customers.show')
            ->with([
                'all_account_classes' => $all_account_classes,
                'all_account_roles' => $all_account_roles,
                'all_login_statuses' => $all_login_statuses,
                'customer_jobs' => $customer_jobs,
                'selected_customer' => $selected_customer,
                'all_referrals' => $all_referrals,
                'all_states' => $all_states,
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
        // Validate The Request Data.
        $request->validate([
            'username' => 'required|unique:users,username,'. $id,
            'email' => 'sometimes|nullable|unique:users,email,'. $id,
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'street_address' => 'required|string|min:8|max:100',
            'suburb' => 'required|string|min:3|max:60',
            'postcode' => 'required|numeric|min:1000|max:9999',
            'state_id' => 'required',
            'home_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:mobile_phone',
            'mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:home_phone',
            'referral_id' => 'required',
            'account_class_id' => 'required',
            'user_description' => 'sometimes|nullable|string|max:255',
            'business_name' => 'sometimes|nullable|string|max:100',
            'abn' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_contact_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_position' => 'sometimes|nullable|string|max:100',
            'bank_name' => 'sometimes|nullable|string|max:100',
            'bank_bsb' => 'sometimes|nullable',
            'bank_account_name' => 'sometimes|nullable|string|max:100',
            'bank_account_number' => 'sometimes|nullable',
            'business_description' => 'sometimes|nullable|string|max:255',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'logo' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);

        // Find the required model instance.
        $selected_customer = User::findOrFail($id);

        // update the selected model instance.
        $selected_customer->update([
            // MODEL RELATIONSHIPS
            'account_class_id' => $request->account_class_id,
            'account_role_id' => $request->account_role_id,
            'referral_id' => $request->referral_id,
            'login_status_id' => $request->login_status_id,
            // STANDARD USER DETAILS
            'username' => $request->username == null ? $request->email : $request->username,
            'email' => $request->email,
            'first_name' => ucwords($request->first_name),
            'last_name' => ucwords($request->last_name),
            'street_address' => ucwords($request->street_address),
            'suburb' => ucwords($request->suburb),
            'state_id' => $request->state_id,
            'postcode' => $request->postcode,
            'home_phone' => str_replace(' ', '', $request->home_phone),
            'mobile_phone' => str_replace(' ', '', $request->mobile_phone),
            'user_description' => ucfirst($request->user_description),
            // MAILING LIST
            'is_subscribed_email' => isset($request->is_subscribed_email) ? 1 : 0,
            // OPTIONAL USER BUSINESS DETAILS
            'business_name' => ucwords($request->business_name),
            'abn' => str_replace(' ', '', $request->abn),
            'business_phone' => str_replace(' ', '', $request->business_phone),
            'business_contact_phone' => str_replace(' ', '', $request->business_contact_phone),
            'business_position' => ucwords($request->business_position),
            'bank_name' => ucwords($request->bank_name),
            'bank_bsb' => str_replace('-', '', $request->bank_bsb),
            'bank_account_name' => ucwords($request->bank_account_name),
            'bank_account_number' => $request->bank_account_number,
            'business_description' => ucfirst($request->business_description)
        ]);

        // OPTIONAL USER IMAGE
        if ($request->hasFile('image')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_customer->image_path != null && file_exists(public_path($selected_customer->image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_customer->image_path));
            }
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/customerImages/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $selected_customer->update([
                'image_path' => 'storage/images/customerImages/' . $filename
            ]);
        }

        // OPTIONAL BUSINESS LOGO
        if ($request->hasFile('logo')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_customer->logo_path != null && file_exists(public_path($selected_customer->logo_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_customer->logo_path));
            }
            // Set the uploaded file.
            $image = $request->file('logo');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/customerLogos/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $selected_customer->update([
                'image_path' => 'storage/images/customerLogos/' . $filename
            ]);
        }

        // Return a redirect to the show route.
        return redirect()
            ->route('customers.show', $selected_customer->id)
            ->with('success', 'You have successfully updated the selected customer.');
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
        $selected_customer = User::findOrFail($id);
        // Upsate the selected model instance.
        $selected_customer->update([
            'login_status_id' => 4, // Is Deleted.
            'is_subscribed_email' => 0 // Not Subscribed.
        ]);
        // Return redirect the the show view.
        return redirect()
            ->route('customers.show', $id)
            ->with('warning', 'You have successfully soft deleted the selected user account. The selected user credentials have been revoked and can no longer be used to login.');
    }
}
