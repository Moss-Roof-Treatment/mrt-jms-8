<?php

namespace App\Http\Controllers\Menu\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountClass;
use App\Models\User;
use Carbon\Carbon;

class AccountClassController extends Controller
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
        // Set The Required Variables.
        // Get all the required account classes.
        $selected_account_classes = AccountClass::has('users')
            ->select('id', 'title')
            ->withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // Get the total user count.
        $total_user_count = User::count();
        // Return the index view.
        return view('menu.reports.accountClasses.index')
            ->with([
                'total_user_count' => $total_user_count,
                'selected_account_classes' => $selected_account_classes
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Validate The Request Data.

        // Check for inputs.
        if ($request->start_date == null && $request->end_date == null) {
            // If no input is present, redirect back with error message.
            return back()
                ->with('warning', 'Please select at least one of the available options to filter the selected report.');
        }

        // Set The Required Variables.

        // Set the start date.
        $start_date = Carbon::parse($request->start_date);
        // Set the end date.
        $end_date = isset($request->end_date)
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::parse($request->start_date)->endOfDay();

        // VALIDATE START AND END DATE
        // Check that start date is before end date. 
        if ($start_date->greaterThan($end_date)) {
            // Return redirect as start date is after the end date.
            return back()
                ->with('warning', 'Please select a starting date that is before the end date to filter the selected report.');
        }

        // Get all users that are not a staff class user.
        $selected_users = User::has('account_class')
            ->where('account_role_id', 5) // Customer
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        // Get total selected users count.
        $total_user_count = $selected_users->count();

        // Group the account classes by id and sort by descending count.
        $account_classes = $selected_users->groupBy('account_class_id')->sortByDesc(function($class)
        {
            // Count of each group of customer account class.
            return $class->count();
        });

        // Return the index view.
        return view('menu.reports.accountClasses.results')
            ->with([
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_user_count' => $total_user_count,
                'account_classes' => $account_classes
            ]);
    }
}
