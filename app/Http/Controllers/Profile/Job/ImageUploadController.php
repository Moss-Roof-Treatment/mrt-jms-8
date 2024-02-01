<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobImage;
use App\Models\JobImageType;
use App\Models\Quote;
use Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Session;

class ImageUploadController extends Controller
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
        // Check if the GET data has been supplied.
        if(!isset($_GET['selected_quote_id'])) {
            return back()
                ->with('danger', 'The job information is required to manage the job images.');
        }
        // Set The Required Variables.
        // Find the required quote.
        $selected_quote = Quote::findOrFail($_GET['selected_quote_id']);
        // All job image types.
        $types = JobImageType::all();
        // Selected job images.
        $job_images = JobImage::where('job_id', $selected_quote->job_id)->get();
        // Selected job images grouped by image type.
        $image_type_collections = $job_images->groupBy('job_image_type_id');
        // Return the index view.
        return view('profile.jobs.images.create')
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
                ? $current_image_count = ++$current_image_counter
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
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
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
        // Flash success message to the session.
        Session::flash('success', 'You have successfully uploaded the selected job image(s).');
    }
}
