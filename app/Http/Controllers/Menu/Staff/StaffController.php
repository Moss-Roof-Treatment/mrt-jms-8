<?php

namespace App\Http\Controllers\Menu\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountClass;
use App\Models\AccountRole;
use App\Models\LoginStatus;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class StaffController extends Controller
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
        // Select all model instances.
        $all_staff_members = User::where('id', '!=', 1)->whereIn('account_role_id', [1,2]) // Staff
            ->with('login_status')
            ->get();
        // Return the index view.
        return view('menu.staff.index')
            ->with('all_staff_members', $all_staff_members);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // All states.
        $all_states = State::all('id', 'title');
        // Return the create view.
        return view('menu.staff.create')
            ->with('all_states', $all_states);
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
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'street_address' => 'required|string|min:8|max:100',
            'suburb' => 'required|string|min:3|max:60',
            'postcode' => 'required|numeric|min:1000|max:9999',
            'state_id' => 'required',
            'home_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:mobile_phone',
            'mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:home_phone',
            'user_description' => 'sometimes|nullable|string|max:500',
            'business_name' => 'sometimes|nullable|string|max:100',
            'abn' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_contact_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_position' => 'sometimes|nullable|string|max:100',
            'bank_name' => 'sometimes|nullable|string|max:100',
            'bank_bsb' => 'sometimes|nullable',
            'bank_account_name' => 'sometimes|nullable|string|max:100',
            'bank_account_number' => 'sometimes|nullable',
            'business_description' => 'sometimes|nullable|string|max:500',
            'has_gst' => 'sometimes|nullable|string',
            'kin_name' => 'sometimes|nullable|string',
            'kin_address' => 'sometimes|nullable|string',
            'kin_mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'kin_relationship' => 'sometimes|nullable|string',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'logo' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Create the new user.
        $new_user = User::create([
            // MODEL RELATIONSHIPS
            'account_class_id' => 1, // Staff.
            'account_role_id' => 2, // Staff.
            'referral_id' => 7, // Not Registered.
            // USER SECTION
            'username' => $request->username ?? $request->email,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'first_name' => ucwords($request->first_name),
            'last_name' => ucwords($request->last_name),
            'street_address' => ucwords($request->street_address) ?? null,
            'suburb' => ucwords($request->suburb) ?? null,
            'state_id' => $request->state_id ?? null,
            'postcode' => $request->postcode ?? null,
            'home_phone' => str_replace(' ', '', $request->home_phone) ?? null,
            'mobile_phone' => str_replace(' ', '', $request->mobile_phone) ?? null,
            'user_description' => ucfirst($request->user_description) ?? null,
            // BUSINESS DETAILS
            'business_name' => ucwords($request->business_name) ?? null,
            'abn' => str_replace(' ', '', $request->abn) ?? null,
            'business_phone' => str_replace(' ', '', $request->business_phone) ?? null,
            'business_contact_phone' => str_replace(' ', '', $request->business_contact_phone) ?? null,
            'business_position' => ucwords($request->business_position) ?? null,
            'bank_name' => ucwords($request->bank_name) ?? null,
            'bank_bsb' => str_replace('-', '', $request->bank_bsb) ?? null,
            'bank_account_name' => ucwords($request->bank_account_name) ?? null,
            'bank_account_number' => $request->bank_account_number ?? null,
            'business_description' => ucfirst($request->business_description) ?? null,
            'has_gst' => $request->has_gst ?? null,
            'super_fund_name' => $request->super_fund_name ?? null,
            'super_member_numnber' => $request->super_member_numnber ?? null,
            // NEXT OF KIN
            'kin_name' => ucfirst($request->kin_name) ?? null,
            'kin_address' => ucfirst($request->kin_address) ?? null,
            'kin_mobile_phone' => $request->kin_mobile_phone ?? null,
            'kin_relationship' => ucfirst($request->kin_relationship) ?? null
        ]);
        // DISPLAY IMAGE
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/staffImages/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $new_user->update([
                'image_path' => 'storage/images/staffImages/' . $filename
            ]);
        }
        // LOGO
        if ($request->hasFile('logo')) {
            // Set the uploaded file.
            $image = $request->file('logo');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/staffLogos/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $new_user->update([
                'logo_path' => 'storage/images/staffLogos/' . $filename
            ]);
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('staff.show', $new_user->id)
            ->with('success', 'You have successfully created a new staff member.');
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
        $selected_user = User::findOrFail($id);
        // Check the user account class.
        if (!in_array($selected_user->account_role_id, [1,2])) { // Staff
            // Return a redirect back.
            return back()
                ->with('danger', 'The selected user does not have the required account role.');
        }
        // Set The Required Variables.
        // All account classes.
        $all_account_classes = AccountClass::all('id', 'title');
        // All account roles.
        $all_account_roles = AccountRole::orderBy('id', 'desc')->get();
        // All login statuses.
        $all_login_statuses = LoginStatus::all('id', 'title');
        // All states.
        $all_states = State::all('id', 'title');
        // Return the show view.
        return view('menu.staff.show')
            ->with([
                'all_account_classes' => $all_account_classes,
                'all_login_statuses' => $all_login_statuses,
                'all_account_roles' => $all_account_roles,
                'all_states' => $all_states,
                'selected_user' => $selected_user
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
            'username' => 'sometimes|nullable|min:7|max:100|required_without:email|unique:users,username,'. $id,
            'email' => 'sometimes|nullable|min:7|max:100|required_without:username|unique:users,email,'. $id,
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'street_address' => 'required|string|min:8|max:100',
            'suburb' => 'required|string|min:3|max:60',
            'postcode' => 'required|numeric|min:1000|max:9999',
            'state_id' => 'required',
            'home_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:mobile_phone',
            'mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:home_phone',
            'user_description' => 'sometimes|nullable|string|max:500',
            'color' => 'required|regex:/^#([A-Fa-f0-9]{6})$/',
            'business_name' => 'sometimes|nullable|string|max:100',
            'abn' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_contact_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'business_position' => 'sometimes|nullable|string|max:100',
            'bank_name' => 'sometimes|nullable|string|max:100',
            'bank_bsb' => 'sometimes|nullable',
            'bank_account_name' => 'sometimes|nullable|string|max:100',
            'bank_account_number' => 'sometimes|nullable',
            'business_description' => 'sometimes|nullable|string|max:500',
            'has_commissions' => 'sometimes|nullable|string',
            'has_gst' => 'sometimes|nullable|string',
            'has_payg' => 'sometimes|nullable|string',
            'kin_name' => 'sometimes|nullable|string',
            'kin_address' => 'sometimes|nullable|string',
            'kin_mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/',
            'kin_relationship' => 'sometimes|nullable|string',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'logo' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Find the required model instance.
        $selected_user = User::findOrFail($id);
        // Update the selected model instance.
        $selected_user->update([
            // MODEL RELATIONSHIPS
            'account_class_id' => $request->account_class_id,
            'account_role_id' => $request->account_role_id,
            'login_status_id' => $request->login_status_id,
            // USER SECTION
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
            'user_color' => $request->color,
            // BUSINESS DETAILS
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
            'has_gst' => $request->has_gst,
            'has_payg' => $request->has_payg,
            'has_commissions' => $request->has_commissions,
            'super_fund_name' => $request->super_fund_name != null ? $request->super_fund_name : null,
            'super_member_numnber' => $request->super_member_numnber != null ? $request->super_member_numnber : null,
            // NEXT OF KIN
            'kin_name' => ucfirst($request->kin_name),
            'kin_address' => ucfirst($request->kin_address),
            'kin_mobile_phone' => $request->kin_mobile_phone,
            'kin_relationship' => ucfirst($request->kin_relationship)
        ]);
        // DISPLAY IMAGE
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_user->image_path != null && file_exists(public_path($selected_user->image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_user->image_path));
            }
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/staffImages/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $selected_user->update([
                'image_path' => 'storage/images/staffImages/' . $filename
            ]);
        }
        // LOGO
        // Check the request data for the required file.
        if ($request->hasFile('logo')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_user->logo_path != null && file_exists(public_path($selected_user->logo_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_user->logo_path));
            }
            // Set the uploaded file.
            $image = $request->file('logo');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/staffLogos/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $selected_user->update([
                'logo_path' => 'storage/images/staffLogos/' . $filename
            ]);
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('staff.show', $id)
            ->with('success', 'You have successfully updated the selected user.');
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
        $selected_user = User::findOrFail($id);
        // Update the selected model instance.
        $selected_user->update([
            'login_status_id' => 4, // Is Deleted.
            'is_subscribed_email' => 0 // Not Subscribed.
        ]);
        // Return redirect the the show view.
        return back()
            ->with('warning', 'You have successfully soft deleted the selected user account. The selected user credentials have been revoked and can no longer be used to login.');
    }
}
