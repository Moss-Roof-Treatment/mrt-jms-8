<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobImage;
use App\Models\JobImageType;
use App\Models\Quote;
use Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
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

            $new_job_image->title = $selected_image_type->title . ' image';
            $new_job_image->description = 'A ' . $selected_image_type->title . ' image.';

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
