<?php

namespace App\Http\Controllers\Menu\Email\Generic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Email;
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
        // Get all emails.
        $emails = Email::all();
        // Create the datetable. 
        return Datatables::of($emails)
            // Default cost column.
            ->editColumn('recipient', function ($email) {
                // Check if name variable exists.
                return $email->recipient_name ?? '<p class="text-center"><span class="badge badge-warning py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>The recipient name was not set</span></p>';
            })
            // Created at column.
            ->editColumn('created_at', function ($email) {
                return $email->created_at->format('d/m/y - h:iA');
            })
            // Add options button column.
            ->addColumn('action', 'menu.emails.generic.actions.actions')
            ->rawColumns(['action'])
            ->make(true);
        }
}
