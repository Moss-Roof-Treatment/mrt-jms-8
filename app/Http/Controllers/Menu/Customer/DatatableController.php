<?php

namespace App\Http\Controllers\Menu\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class DatatableController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('account_role_id', 5) // Customer
            ->select('id', 'first_name', 'last_name', 'business_name', 'email', 'last_login_date');

        return Datatables::of($users)
            // First name.
            ->editColumn('first_name', function($user){
                // Add the lastname to the firstname.
                return $user->getFullNameAttribute();
            })
            // Merge first name and last name together.
            ->editColumn('email', function($user){
                if ($user->email == null) {
                    // Return the username.
                    return '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // Return the email address.
                    return $user->email;
                }
            })
            // Add options button column.
            ->editColumn('last_login_date', function ($user) {
                // Return the not applicable badge.
                return $user->getLastLoginAttribute();
            })
            // Add options button column.
            ->editColumn('business_name', function ($user) {
                // Check if the business name is null.
                if ($user->business_name == null) {
                    // Return the not applicable badge.
                    return '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // Return the business name.
                    return $user->business_name;
                }
            })
            // Add options button column.
            ->addColumn('action', function ($user) {
                return '<a href="'. route('customers.show', $user->id).'" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            ->rawColumns(['email', 'last_login_date', 'business_name', 'action'])
            ->make();
    }
}
