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
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
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
        // Check the request data for the required file.
        if ($request->hasFile('file')) {
            // Find job image count.
            $current_image_counter = JobImage::where('job_id', $selected_job_id)->count();
            // Get the image type title.
            $selected_image_type = JobImageType::find($request->image_type);
            // Set the image identifier.
            $current_image_counter >= 1
                ? ++$current_image_counter
                : $current_image_count = 1;
           // Create new model instance.
           $new_job_image = JobImage::create([
                'job_id' => $selected_job_id,
                'staff_id' => Auth::id(),
                'job_image_type_id' => $request->image_type,
                'image_identifier' => $selected_job_id . ' - ' . $current_image_count,
                'colour_id' => 1, // Set default colour value.
                'title' => $selected_image_type->title . ' image',
                'description' => 'A ' . $selected_image_type->title . ' image.',
            ]);
            // Set the uploaded file.
            $image = $request->file('file');
            // Set the new file name.
            $filename = Str::slug($new_job_image->job_id . ' ' . $selected_image_type->title) . '-' . rand(0, 99) . time() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/jobs/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(1280, 720)->toJpeg(80)->save($location);
            // Update the selected model instance.
            $new_job_image->update([
                'image_path' => 'storage/images/jobs/' . $filename
            ]);
        }
        // Sucess message.
        Session::flash('success', 'You have successfully uploaded the selected job image(s).');
    }
}
