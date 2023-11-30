<?php

namespace App\Http\Controllers\Menu\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Confirm request data exists.
        if ($request->first_name == null && $request->last_name == null && $request->street_address == null && $request->suburb == null && $request->postcode == null && $request->email == null && $request->business_phone == null) {
            // Return a redirect to the index route.
            return redirect()
                ->route('customers.index')
                ->with('warning', 'You must enter at least one field to search for a user.');
        }

        // Validate The Request Data.
        $request->validate([
            'first_name' => 'sometimes|nullable|string|min:3|max:50',
            'last_name' => 'sometimes|nullable|string|min:3|max:50',
            'street_address' => 'sometimes|nullable|string|min:8|max:100',
            'suburb' => 'sometimes|nullable|string|min:3|max:60',
            'postcode' => 'sometimes|nullable|numeric|min:1000|max:9999',
            'email' => 'sometimes|nullable|string|min:8|max:100',
            'business_name' => 'sometimes|nullable|numeric',
        ]);

        // Find required model instances.
        // Search through only users with the customer account role "5" customers.
        $users = User::where('account_role_id', '5')->where(function($q) use ($request) { // Customers.
            // First name.
            if (isset($request->first_name)) {
                $q->orWhere('first_name','LIKE','%'.$request->first_name.'%');
            }
            // Last name.
            if (isset($request->last_name)) {
                $q->orWhere('last_name','LIKE','%'.$request->last_name.'%');
            }
            // Street Address.
            if (isset($request->street_address)) {
                $q->orWhere('street_address','LIKE','%'.$request->street_address.'%');
            }   
            // Suburb.
            if (isset($request->suburb)) {
                $q->orWhere('suburb','LIKE','%'.$request->suburb.'%');
            }   
            // Postcode.
            if (isset($request->postcode)) {
                $q->orWhere('postcode','LIKE','%'.$request->postcode.'%');
            }
            // Email.
            if (isset($request->email)) {
                $q->orWhere('email','LIKE','%'.$request->email.'%');
            }
            // Business name.
            if (isset($request->business_name)) {
                $q->orWhere('business_name','LIKE','%'.$request->business_name.'%');
            }
        })->get();

        // Set The Required Variables.
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'street_address' => $request->street_address,
            'suburb' => $request->suburb,
            'postcode' => $request->postcode,
            'email' => $request->email,
            'business_name' => $request->business_name
        ];

        // Return the show view.
        return view('menu.customers.results')
            ->with([
                'data' => $data,
                'users' => $users
            ]);
    }
}