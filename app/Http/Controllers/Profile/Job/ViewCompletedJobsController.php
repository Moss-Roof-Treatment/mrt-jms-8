<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\JobImage;
use App\Models\JobProgress;
use App\Models\Quote;
use Auth;
use Yajra\Datatables\Datatables;

class ViewCompletedJobsController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set the required variables.
        // All of the old non active authenticated user quotes.
        $quotes = Quote::whereHas('quote_users', fn ($q) => $q->where('tradesperson_id', Auth::id()))
            ->whereHas('invoices', fn ($q) => $q->where('user_id', Auth::id()))
            ->where('finalised_date', '!=', null)
            ->select('id', 'job_id', 'job_type_id', 'customer_id', 'quote_status_id') // Select only required columns.
            ->with(['job' => fn ($q) => $q->select('id', 'tenant_suburb','tenant_postcode')]) // With belongsTo relationship, only required columns. 
            ->with(['customer' => fn ($q) => $q->select('id', 'first_name','last_name')]) // With belongsTo relationship, only required columns. 
            ->with(['quote_status' => fn ($q) => $q->select('id', 'title')]) // With belongsTo relationship, only required columns. 
            ->with(['job_type' => fn ($q) => $q->select('id', 'title')]) // With belongsTo relationship, only required columns. 
            ->with(['invoices' => fn ($q) => $q->where('user_id', Auth::id())]) // With hasMany relationship.
            ->get();

        // Construct the datatable.
        return Datatables::of($quotes)
            // Edit the ID field.
            ->editColumn('id', function ($quote) {
                // Return the link to view the html link.
                return '<a href="' . route('profile-old-jobs.show', $quote->id) . '">' . $quote->job_id . '</a>';
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
            // Edit the job_type_id field.
            ->editColumn('job_type_id', function ($quote) {
                // Check if the job_type_id is null.
                if ($quote->job_type_id == null) {
                    // The job_type_id is null.
                    return '<span class="badge badge-warning py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>No job type set</span>';
                } else {
                    // The job_type_id is not null.
                    return '<span class="badge badge-dark py-2 px-2"><i class="fas fa-tools mr-2" aria-hidden="true"></i>' . $quote->job_type->title . '</span>';
                }
            })
            // Edit the quote_status_id field.
            ->editColumn('quote_status_id', function ($quote) {
                // Quote status title.
                return $quote->quote_status->title;
            })
            // Edit the invoice_identifier field.
            ->addColumn('invoice_identifier', function ($quote) {
                // Check if the invoice is null.
                if ($quote->invoices() == null) {
                    // Return the null badge.
                    return '<span class="badge badge-warning py-2 px-2"><i class="fas fa-times mr-2" aria-hidden="true"></i>None</span>';
                } else {
                    // Get the values.
                    $id_array = $quote->invoices->pluck('id')->toArray();
                    $identifier_array = $quote->invoices->pluck('identifier')->toArray();
                    $date_array = $quote->invoices->pluck('paid_date')->toArray();
                    // flattern the arrays to string.
                    $invoice_id = implode(",", $id_array);
                    $identifier = implode(",", $identifier_array);
                    // Format the date.
                    // return the date or badge.
                    $date_array == null
                    ? $value = '<span class="badge badge-warning py-2 px-2"><i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending</span>'
                    : $value = '<a href="' . route('profile-invoices.show', $invoice_id) . '">' . $identifier . '</a> ';
                    return $value;
                }
            })
            // Edit the invoice_identifier field.
            ->addColumn('invoice_paid_date', function ($quote) {
                // Get the values.
                $date_array = $quote->invoices->pluck('paid_date')->toArray();
                // flattern the arrays to string.
                $unformatted_date = implode(",", $date_array);
                // Format the date.
                $date = $unformatted_date == null
                ? '<span class="badge badge-warning py-2 px-2"><i class="fas fa-stopwatch mr-2" aria-hidden="true"></i>Is Pending</span>' 
                : date('d/m/Y', strtotime($unformatted_date));
                // return the date or badge.
                return $date;
            })
            // Add options button column.
            ->addColumn('action', function ($quote) {
                // Return the link to view the html link.
                return '<a href="' . route('profile-old-jobs.show', $quote->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-eye mr-2" aria-hidden="true"></i>View</a>';
            })
            ->rawColumns(['id', 'job_type_id', 'invoice_identifier', 'invoice_paid_date', 'action'])
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
        $selected_quote = Quote::findOrFail($id);
        // Job progress dropdown.
        $job_progresses = JobProgress::all('id', 'title');
        // All internal notes.
        $all_internal_notes = Note::where('job_id', $selected_quote->job_id)
            ->where('recipient_id', Auth::id())
            ->where('is_internal', 1)
            ->orderBy('id', 'desc')
            ->get();
        // All job images.
        $job_images = JobImage::where('job_id', $selected_quote->job_id)
            ->with(['colour' => fn ($q) => $q->select('id', 'brand', 'text_brand')])
            ->with(['job_image_type' => fn ($q) => $q->select('id', 'title')])
            ->with(['staff' => fn ($q) => $q->select('id', 'first_name', 'last_name')])
            ->select(['id', 'image_path', 'colour_id', 'description', 'title', 'job_image_type_id', 'staff_id', 'created_at'])
            ->get();
        // Group job images by image type id.
        $image_type_collections = $job_images->groupBy('job_image_type_id');
        // Return the show view.
        return view('profile.jobs.old.show')
            ->with([
                'all_internal_notes' => $all_internal_notes,
                'image_type_collections' => $image_type_collections,
                'job_progresses' => $job_progresses,
                'selected_quote' => $selected_quote
            ]);
    }
}
