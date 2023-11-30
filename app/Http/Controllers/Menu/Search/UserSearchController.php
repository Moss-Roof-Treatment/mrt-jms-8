<?php

namespace App\Http\Controllers\Menu\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserSearchController extends Controller
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
        return view('menu.search.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Confirm request data exists.
        if ($request->first_name == null && $request->last_name == null && $request->street_address == null && $request->suburb == null && $request->postcode == null && $request->email == null && $request->home_phone == null && $request->business_phone == null) {
            // Return a redirect back.
            return back()
                ->with('warning', 'You must enter at least one field to search for a user.');
        }
        // Validate The Request Data.
        $request->validate([
            'email' => 'sometimes|nullable|email',
            'first_name' => 'sometimes|nullable|string|min:3|max:50',
            'last_name' => 'sometimes|nullable|string|min:3|max:50',
            'street_address' => 'sometimes|nullable|string|min:8|max:100',
            'suburb' => 'sometimes|nullable|string|min:3|max:60',
            'postcode' => 'sometimes|nullable|numeric|min:1000|max:9999',
            'home_phone' => 'sometimes|nullable|numeric',
            'mobile_phone' => 'sometimes|nullable|numeric',
            'business_phone' => 'sometimes|nullable|numeric',
        ]);
        // Find selected model instances.
        $users = User::where(function($q) use ($request) {
            // First Name.
            if (isset($request->first_name)) {
                $q->orWhere('first_name','LIKE','%'.$request->first_name.'%');
            }
            // Last Name.
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
            // Home Phone.
            if (isset($request->home_phone)) {
                $q->orWhere('home_phone','LIKE','%'.$request->home_phone.'%');
            }
            // Mobile Phone.
            if (isset($request->mobile_phone)) {
                $q->orWhere('mobile_phone','LIKE','%'.$request->mobile_phone.'%');
            }
            // Business Phone.
            if (isset($request->business_phone)) {
                $q->orWhere('business_phone','LIKE','%'.$request->business_phone.'%');
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
            'home_phone' => $request->home_phone,
            'mobile_phone' => $request->mobile_phone,
            'business_phone' => $request->business_phone
        ];
        // Return the show view.
        return view('menu.search.users.show')
            ->with([
                'users' => $users,
                'data' => $data
            ]);
    }
}
