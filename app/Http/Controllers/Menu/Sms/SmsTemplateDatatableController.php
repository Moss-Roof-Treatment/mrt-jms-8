<?php

namespace App\Http\Controllers\Menu\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsTemplate;
use Yajra\Datatables\Datatables;

class SmsTemplateDatatableController extends Controller
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
        $sms_templates = SmsTemplate::select('id', 'title', 'text');
        // Create the datatable.
        return Datatables::of($sms_templates)
            // Job ID 
            ->editColumn('text', function ($sms_template) {
                if ($sms_template->text == null) {
                    // The text is null.
                    // Return the not applicable badge.
                    return '<span class="badge badge-light py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>Not Applicable</span>';
                } else {
                    // Shorten note text.
                    $text = substr($sms_template->text, 0, 80);
                    // Add ellipsis if the text exceeds the specified length count.
                    $text_ellipsis = strlen($sms_template->text) > 80 ? '...' : '';
                    // The note is read do not bold the text.
                    return $text . $text_ellipsis;
                }
            })
            // Add options button column.
            ->addColumn('action', function ($sms_template) {
                return '<a href="'. route('sms-templates.show', $sms_template->id).'" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            ->rawColumns(['job_id', 'sender_id', 'text', 'action'])
            ->make(true);
    }
}
