<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerSearchController extends Controller
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
    public function index(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'customer_name' => 'required|string|min:2|max:80',
        ]);
        // Find selected model instances.
        $users = User::where(function($q) use ($request) {
            // First name.
            if (isset($request->customer_name)) {
                $q->orWhere('first_name','LIKE','%'.$request->customer_name.'%');
            }
            // Last name.
            if (isset($request->customer_name)) {
                $q->orWhere('last_name','LIKE','%'.$request->customer_name.'%');
            }
        })->where('account_role_id', 5) // Customer
            ->get();
        // Check if there are any results.
        if (!$users->count()) {
            // Users do not exist.
            // Return a redirect back. 
            return back()
                ->with('warning', 'There is no user that matches the name that you have entered.');
        } else {
            // Users exist.
            // Return the search results index view. 
            return view('menu.customers.menuSearchResults.index')
                ->with('users', $users);
        }
    }
}
