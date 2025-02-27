<?php

namespace App\Http\Controllers\Menu\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;

class ConvertLeadToCustomerController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Set The Required Variables.
        // Find the required model instance.
        $selected_lead = Lead::findOrFail($request->lead_id);

        // Secondary validation.
        // Check if there is an already existing user.
        $existing_user = User::where('email', $selected_lead->email)->first();
        // Check if the existing user variable is not null.
        if ($existing_user != null) {
            // There is an existing user. Return a redirect back.
            return back()
                ->with('danger', 'There is already a user with the entered email.');
        }

        // Set The Required Variables.
        // GENERATE A PASSWORD
        // Set the available characters string.
        $chars = "abcdefghmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        // Shuffle the characters string and trim the first 8 characters.
        $random_string = substr(str_shuffle($chars), 0, 8);

        // Create the new model instance.
        $new_user = User::create([
            'username' => $selected_lead->email,
            'email' => $selected_lead->email,
            'first_name' => ucwords($selected_lead->first_name),
            'last_name' => ucwords($selected_lead->last_name),
            'street_address' => ucwords($selected_lead->street_address),
            'suburb' => ucwords($selected_lead->suburb),
            'state_id' => ucwords($selected_lead->state_id),
            'postcode' => $selected_lead->postcode,
            'home_phone' => $selected_lead->home_phone,
            'mobile_phone' => $selected_lead->mobile_phone,
            'business_name' => ucwords($selected_lead->business_name),
            'business_phone' => $selected_lead->business_phone,
            'abn' => $selected_lead->abn,
            'user_description' => ucfirst($selected_lead->description),
            'referral_id' => $selected_lead->referral_id ?? 1,
            'account_class_id' => $selected_lead->account_class_id ?? 5, // Default - Individual.
            'account_role_id' => 5, // Customer. 
            'password' => bcrypt($random_string) // Random string of characters.
        ]);

        // Delete the selected model instance relationships.
        $selected_lead->lead_contacts()->delete();
        // Check if the file path value is not null and file exists on the server.
        if ($selected_lead->image_path != null && file_exists(public_path($selected_lead->image_path))) {
            // Delete the file from the server.
            unlink(public_path($selected_lead->image_path));
        }

        // Delete the new model instance.
        $selected_lead->delete();

        // Return the show view.
        return redirect()
            ->route('customers.show', $new_user->id)
            ->with('success', 'You have successfully converted the customer lead into a customer');
    }
}
