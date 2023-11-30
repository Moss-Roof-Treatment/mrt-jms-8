<?php

namespace App\Http\Controllers\Menu\Settings\Postcode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Postcode;
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
        $postcodes = Postcode::all();

        return Datatables::of($postcodes)
            // Add options button column.
            ->addColumn('action', 'menu.settings.postcodes.actions.postcodeActions')
            ->rawColumns(['action'])
            ->make(true);
    }
}
