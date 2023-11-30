<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\Note;
use App\Models\JobImage;
use App\Models\JobProgress;
use App\Models\Quote;
use App\Models\SmsTemplate;
use Auth;
use Yajra\Datatables\Datatables;

class JobController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAnyStaffMember');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return the index view.
        return view('profile.jobs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set the required variables.
        // All of the current active authenticated user quotes.
        $quotes = Quote::whereHas('quote_users', fn ($q) => $q->where('tradesperson_id', Auth::id()))
            ->whereDoesntHave('invoices', fn ($q) => $q->where('user_id', Auth::id()))
            ->where('finalised_date', '!=', null)
            ->select('id', 'job_id', 'job_type_id', 'customer_id', 'quote_status_id')
            ->with(['job' => fn ($q) => $q->select('id', 'tenant_suburb','tenant_postcode', 'sold_date')])
            ->with(['customer' => fn ($q) => $q->select('id', 'first_name','last_name')])
            ->with(['quote_status' => fn ($q) => $q->select('id', 'title')])
            ->get();

        // Construct the datatable.
        return Datatables::of($quotes)
            // Edit the ID field.
            ->editColumn('id', function ($quote) {
                // Return the link to view the html link.
                return '<a href="' . route('profile-jobs.show', $quote->id) . '">' . $quote->job_id . '</a>';
            })
            // Edit the customer_id field.
            ->editColumn('customer_id', function ($quote) {
                // Customer full name.
                return $quote->customer->getFullNameAttribute();
            })
            // Add the suburb field.
            ->addColumn('suburb', function ($quote) {
                // Shorten note text.
                return $quote->job->tenant_suburb . ', ' . $quote->job->tenant_postcode;
            })
            // Edit the quote status field.
            ->editColumn('quote_status_id', function ($quote) {
                // Quote status title.
                return $quote->quote_status->title;
            })
            // Edit the sold date field.
            ->editColumn('sold_date', function ($quote) {
                // Format the date.
                $date = $quote->job->sold_date == null
                ? '<span class="badge badge-warning py-2 px-2"><i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending</span>' 
                : date('d/m/Y', strtotime($quote->job->sold_date));
                // return the date or badge.
                return $date;
            })
            // Add options button column.
            ->addColumn('action', function ($quote) {
                // Return the link to view the html link.
                return '<a href="' . route('profile-jobs.show', $quote->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            ->rawColumns(['id', 'sold_date', 'invoice', 'action'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Set The Required Variables.
        $selected_quote = Quote::with('job_type')
            ->with(['customer' => fn ($q) => $q->select('id', 'first_name', 'last_name', 'street_address', 'suburb', 'postcode', 'home_phone', 'mobile_phone', 'email')])
            ->with(['job' => fn ($q) => $q->select('id', 'job_progress_id', 'salesperson_id', 'tenant_name', 'tenant_home_phone', 'tenant_mobile_phone', 'tenant_suburb', 'tenant_postcode', 'material_type_id', 'building_style_id', 'building_type_id', 'start_date', 'completion_date', 'job_status_id', 'job_id')])
            ->with('quote_status')
            ->with('job.job_types')
            ->with('job.job_progress')
            ->select(['id', 'customer_id', 'quote_status_id', 'job_id'])
            ->findOrFail($id);
        // Job progress dropdown.
        $job_progresses = JobProgress::all('id', 'title');
        // NOTES
        // Internal Notes
        $all_internal_notes = Note::where('job_id', $selected_quote->job_id)
            ->where('is_internal', 1)
            ->where(fn ($q) => 
                $q->where('recipient_id', Auth::id())
                ->orWhere('sender_id', Auth::id())
                ->orWhere('profile_job_can_see', 1)
            ) // where sender, recipient or marked to see.
            ->orderBy('id', 'desc')
            ->with('sender')
            ->with('recipient')
            ->get();
        // Public Notes
        $all_public_notes = Note::where('job_id', $selected_quote->job_id)
            ->where('is_internal', 0)
            ->where(fn ($q) => 
                $q->where('recipient_id', Auth::id())
                ->orWhere('sender_id', Auth::id())
            ) // where sender or recipient.
            ->orderBy('id', 'desc')
            ->with('sender')
            ->with('recipient')
            ->get();
        // All job images.
        $job_images = JobImage::where('job_id', $selected_quote->job_id)
            ->with(['colour' => fn ($q) => $q->select('id', 'brand', 'text_brand')])
            ->with(['job_image_type' => fn ($q) => $q->select('id', 'title')])
            ->with(['staff' => fn ($q) => $q->select('id', 'first_name', 'last_name')])
            ->select(['id', 'image_path', 'colour_id', 'description', 'title', 'job_image_type_id', 'staff_id', 'created_at'])
            ->get();
        // Group job images by their image type.
        $image_type_collections = $job_images->groupBy('job_image_type_id');
        // Find all the required emails.
        $selected_email_template = EmailTemplate::find(21); // Start Date Changed.
        // Find all the required emails.
        $selected_sms_template = SmsTemplate::find(9); // Start Date Changed.
        // Return the show view.
        return view('profile.jobs.show')
            ->with([
                'all_internal_notes' => $all_internal_notes,
                'all_public_notes' => $all_public_notes,
                'image_type_collections' => $image_type_collections,
                'job_progresses' => $job_progresses,
                'selected_email_template' => $selected_email_template,
                'selected_sms_template' => $selected_sms_template,
                'selected_quote' => $selected_quote
            ]);
    }
}
