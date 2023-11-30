<?php

namespace App\Http\Controllers\Menu\Settings\Referral;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referral;
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
        $referrals = Referral::withCount('users')
            ->get();

        return Datatables::of($referrals)
            ->editColumn('description', function ($referral) {
                // Shorten referral description.
                $description = substr($referral->description, 0, 500);
                // Add ellipsis if the description exceeds the specified length count.
                $description_ellipsis = strlen($referral->description) > 500 ? '...' : '';

                return $description . $description_ellipsis;
            })
            // Count of use field.
            ->addColumn('count', function ($referral) {
                // The count of how many times this referral has been used on a quote.
                return $referral_count = $referral->users_count;
            })
            // Add options button column.
            ->addColumn('action', function ($referral) {
                // Button 1
                return '<a href="' . route('referral-settings.edit', $referral->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit mr-2" aria-hidden="true"></i>Edit</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
