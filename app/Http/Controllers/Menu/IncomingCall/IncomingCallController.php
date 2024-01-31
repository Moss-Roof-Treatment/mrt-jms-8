<?php

namespace App\Http\Controllers\Menu\IncomingCall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Postcode;
use App\Models\User;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class IncomingCallController extends Controller
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
        return view('menu.incomingCall.index');
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
            'business_name' => 'sometimes|nullable|string|min:3|max:100',
            'abn' => 'sometimes|nullable|numeric',
            'business_phone' => 'sometimes|nullable|numeric',
            'username' => 'sometimes|nullable|min:7|max:100|required_without:email|unique:users,username',
            'email' => 'sometimes|nullable|min:7|max:100|required_without:username|unique:users,email',
            'first_name' => 'required|string|min:2|max:50',
            'last_name' => 'required|string|min:2|max:50',
            'street_address' => 'required|string|min:8|max:100',
            'suburb' => 'required|string',
            'state' => 'required|string',
            'home_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:mobile_phone',
            'mobile_phone' => 'sometimes|nullable|regex:/^[\s\d]+$/|required_without:home_phone',
            'referral_id' => 'sometimes|nullable',
            'account_class_id' => 'sometimes|nullable',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'logo' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Set The Required Variables.
        // Find the required suburb.
        $selected_suburb = Postcode::find($request->suburb);
        // GENERATE A PASSWORD
        // Set the available characters string.
        $chars = "abcdefghmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        // Shuffle the characters string and trim the first 8 characters.
        $random_string = substr(str_shuffle($chars),0,8);
        // Create the new model instance.
        $new_user = User::create([
            'business_name' => ucwords($request->business_name),
            'abn' => $request->abn,
            'business_phone' => $request->business_phone,
            'username' => $request->username == null ? $request->email : $request->username,
            'email' => $request->email == null ? null : $request->email,
            'password' => bcrypt($random_string), // Random string of characters.
            'first_name' => ucwords($request->first_name),
            'last_name' => ucwords($request->last_name),
            'street_address' => ucwords($request->street_address),
            'suburb' => ucwords($selected_suburb->title),
            'postcode' => $selected_suburb->code,
            'state_id' => $request->state,
            'home_phone' => $request->home_phone,
            'mobile_phone' => $request->mobile_phone,
            'referral_id' => $request->referral_id ?? 1, // Not Registered.
            'account_class_id' => $request->account_class_id ?? 3, // Individual.
            'account_role_id' => 5, // Customer.
            'login_status_id' => 1, // Has access.
        ]);
        // DISPLAY IMAGE
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::slug($new_user->first_name . '_' . $new_user->last_name) . '-image-' . time() . '.' . $image->getClientOriginalExtension();
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
            $filename = Str::slug($new_user->first_name . '_' . $new_user->last_name) . '-logo-' . time() . '.' . $image->getClientOriginalExtension();
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
        // Return redirect to job create route.
        return redirect()
            ->route('jobs.create', ['selected_customer_id' => $new_user->id])
            ->with([
                'selected_user_id' => $new_user->id,
                'success' => 'You have successfully created a new customer.'
            ]);
    }
}
