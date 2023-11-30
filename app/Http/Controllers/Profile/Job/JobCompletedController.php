<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\JobImage;
use App\Models\JobImageType;
use App\Models\JobStatus;
use App\Models\Note;
use App\Models\Quote;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Session;

class JobCompletedController extends Controller
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
        // Check if an invoice already exists.
        // Check for an invoice that has already been created.
        $selected_invoice = Invoice::where('user_id', Auth::id())
            ->where('quote_id', $_GET['selected_quote_id'])
            ->first();
        // If invoice exists.
        if ($selected_invoice != null) {
            // Return redirect to the selected invoice on the tradesperson invoice show page.
            return redirect()
                ->route('profile-invoices.show', $selected_invoice->id)
                ->with('selected_invoice', $selected_invoice);
        }
        // Set The Required Variables.
        // Selected job image.
        $selected_quote = Quote::find($_GET['selected_quote_id']);
        // All job image types.
        $types = JobImageType::all();
        // Selected job images.
        $job_images = JobImage::where('job_id', $selected_quote->job_id)->get();
        // Selected job images grouped by image type.
        $image_type_collections = $job_images->groupBy('job_image_type_id');
        // Find the required job.
        $selected_job = Job::find($selected_quote->job_id);
        // Find the required event.
        $selected_event = Event::where('job_id', $selected_job->id)
            ->first();
        // Set current status to check later if the functionality need to be performed.
        $current_quote_status_id = $selected_quote->quote_status_id;
        // Set current status to check later if the functionality need to be performed.
        $current_job_status_id = $selected_quote->job->job_status_id;
        // QUOTE CHANGES
        // Check if the quote status is already set to completed.
        if($current_quote_status_id != 6) { // Completed.
            // Set the status as it was not already set to completed yet.
            // Update the quote.
            $selected_quote->update([
                'quote_status_id' => 6, // Completed.
                'completion_date' => $selected_quote->completion_date == null ? Carbon::now() : $selected_job->completion_date
            ]);
            // Make the note.
            Note::create([
                'job_id' => $selected_job->id,
                'text' => '"QUOTE STATUS" changed to "COMPLETED" by tradesperson - ' . Auth::user()->getFullNameAttribute() . '.',
                'is_internal' => 1,
                'profile_job_can_see' => 1, // Is visible on profile job page.
                'jms_seen_at' => Carbon::now(),
                'jms_acknowledged_at' => Carbon::now()
            ]);
        }
        // JOB CHANGES 
        // Check if the quote status is already set to completed.
        if($current_job_status_id != 7) { // Completed.
            // Set the status as it was not already set to completed yet.
            // Update the job.
            $selected_job->update([
                'job_status_id' => 7, // Completed.
                'completion_date' => $selected_job->completion_date == null ? Carbon::now() : $selected_job->completion_date,
                'sold_date' => $selected_job->sold_date == null ? Carbon::now() : $selected_job->sold_date
            ]);
            // Make the note.
            Note::create([
                'job_id' => $selected_job->id,
                'text' => '"JOB STATUS" changed to "COMPLETED" by tradesperson - ' . Auth::user()->getFullNameAttribute() . '.',
                'is_internal' => 1,
                'profile_job_can_see' => 1, // Is visible on profile job page.
                'jms_seen_at' => Carbon::now(),
                'jms_acknowledged_at' => Carbon::now()
            ]);
        }
        // Update the corresponding event.
        // Check if the event exists.
        if ($selected_event != null) {
            // Set The Required Variables.
            $selected_job_status = JobStatus::find(7); // Completed.
            // Update the selected event.
            $selected_event->update([
                'description' => 'The work completed button has been pressed by the tradesperson on the job. This job and quote has now been marked as completed - ' . Auth::user()->getFullNameAttribute() . '.',
                'color' => $selected_job_status->color,
                'textColor' => $selected_job_status->text_color
            ]);
        }
        // Return the index view.
        return view('profile.jobs.completed.index')
            ->with([
                'selected_quote' => $selected_quote,
                'types' => $types,
                'image_type_collections' => $image_type_collections
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Set The Required Variables.
        $selected_job_id = $request->job_id;

        if ($request->hasFile('file')) {

            $image = $request->file('file');

            // Find job image count.
            $current_image_counter = JobImage::where('job_id', $selected_job_id)->count();

            // Set the number for the image identifier
            if ($current_image_counter >= 1) {
                $current_image_count = ++$current_image_counter;
            } else {
                $current_image_count = 1;
            }

            // New model instance.
            $new_job_image = new JobImage;

            // Assign data to the image.
            $new_job_image->job_id = $selected_job_id;
            $new_job_image->staff_id = Auth::id();
            $new_job_image->job_image_type_id = $request->image_type;
            $new_job_image->image_identifier = $selected_job_id . ' - ' . $current_image_count;
            $new_job_image->colour_id = 1; // Set default colour value.

            // Get the image type title.
            $selected_image_type = JobImageType::find($request->image_type);

            // Create file name from job id, image type and time.
            $filename = Str::slug($new_job_image->job_id . ' ' . $selected_image_type->title) . '-' . rand(0, 99) . time() . '.' . $image->getClientOriginalExtension();
            // Create the image path.
            $new_job_image->image_path = 'storage/images/jobs/' . $filename;        
            // Create the image location.
            $location = public_path($new_job_image->image_path);
            // Resize the image and keep the aspect ratio, then save the image.
            Image::make($image)->orientate()->resize(1280, 720)->save($location);

            // Save The new job image.
            $new_job_image->save();
        }

        Session::flash('success', 'You have successfully uploaded the selected job image(s).');
    }
}
