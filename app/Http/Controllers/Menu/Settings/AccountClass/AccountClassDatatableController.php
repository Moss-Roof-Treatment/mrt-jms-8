<?php

namespace App\Http\Controllers\Menu\Settings\AccountClass;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountClass;
use Yajra\Datatables\Datatables;

class AccountClassDatatableController extends Controller
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
        $account_class = AccountClass::all();

        return Datatables::of($account_class)
            // Count of use field.
            ->editColumn('title', function ($account_class) {
            // Shorten note text.
                $text = substr($account_class->title, 0, 500);
                // Add ellipsis if the text exceeds the specified length count.
                $text_ellipsis = strlen($account_class->title) > 500 ? '...' : '';

                return $text . $text_ellipsis;
            })
            // Count of use field.
            ->editColumn('description', function ($account_class) {
            // Shorten note text.
                $text = substr($account_class->description, 0, 500);
                // Add ellipsis if the text exceeds the specified length count.
                $text_ellipsis = strlen($account_class->description) > 500 ? '...' : '';

                return $text . $text_ellipsis;
            })
            // Add options button column.
            ->addColumn('action', 'menu.settings.accountClasses.actions.accountClassesActions')
            ->rawColumns(['action'])
            ->make(true);
    }
}
