<?php

namespace App\Http\Controllers\Menu\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GenericSms;
use Yajra\Datatables\Datatables;

class GenericSmsDatatableController extends Controller
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
        // All new notes with no responses.
        $sent_sms = GenericSms::select('id', 'job_id', 'recipient_name', 'mobile_phone', 'created_at');
        // Create the datatable.
        return Datatables::of($sent_sms)
            // Job ID 
            ->editColumn('job_id', function ($sms) { 
                if ($sms->job_id == null) {
                    // Return the no job id badge.
                    return '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // return a link to view the job.
                    return "<a href='" . route('jobs.show', $sms->job_id) . "'>" . $sms->job_id . "</a>";
                }
            })
            ->editColumn('created_at', function ($sms) {
                return $sms->created_at->format('d/m/y - h:iA');
            })
            // Add options button column.
            ->addColumn('action', function ($sms) {
                return '<a href="'. route('generic-sms.show', $sms->id).'" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            ->rawColumns(['job_id', 'sender_id', 'text', 'action'])
            ->make(true);
    }
}
