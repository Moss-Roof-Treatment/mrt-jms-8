<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colour;
use App\Models\DefaultImageText;
use App\Models\DefaultImageTitle;
use App\Models\Job;
use App\Models\JobImage;
use App\Models\JobImageType;
use Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Session;

class ImageController extends Controller
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
        // Set The Required Variables.
        // Find the required job.
        $job = Job::with('quotes')->find($_GET['job_id']);
        // All job image types.
        $types = JobImageType::all();
        // Selected job images.
        $job_images = JobImage::where('job_id', $job->id)->get();
        // Selected job images grouped by image type.
        $image_type_collections = $job_images->groupBy('job_image_type_id');
        // Return a redirect to the create page.
        return view('menu.jobs.images.create')
            ->with([
                'job' => $job,
                'types' => $types,
                'image_type_collections' => $image_type_collections,
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
        // Check if the file exists in the request data.
        if ($request->hasFile('file')) {
            // Create the new image.
            $image = $request->file('file');

            // New model instance.
            $new_job_image = new JobImage;
            $new_job_image->job_id = $selected_job_id;
            $new_job_image->staff_id = Auth::id();
            $new_job_image->job_image_type_id = $request->image_type;
            $new_job_image->colour_id = 1; // Set default colour value.

            // Get the image type title.
            $selected_image_type = JobImageType::find($request->image_type);

            $new_job_image->title = $selected_image_type->title . ' image';
            $new_job_image->description = 'A ' . $selected_image_type->title . ' image.';

            // Create the new image.
            $filename = Str::slug($new_job_image->job_id . ' ' . $selected_image_type->title) . '-' . rand(0, 99) . time() . '.' . $image->getClientOriginalExtension();
            $new_job_image->image_path = 'storage/images/jobs/' . $filename;      
            $location = public_path($new_job_image->image_path);
            Image::make($image)->orientate()->resize(1280, 720)->save($location);

            // Save The new job image.
            $new_job_image->save();
        }

        /*
        |--------------------------------------------------------------------------
        // Reset the image identifier.
        |--------------------------------------------------------------------------
        */

        // Find all job images of the uploaded type.
        $all_job_images = JobImage::where('job_id', $selected_job_id)
            ->where('job_image_type_id', $request->image_type)
            ->get();

        // Set an integer to 1 to be incremented in the loop
        $i = 1;

        // Loop through each job image.
        foreach($all_job_images as $selected_job_image) {

            // Update the image identifier.
            $selected_job_image->image_identifier = substr($selected_job_image->job_image_type->title, 0, 1) . ' - ' . $i++;
            $selected_job_image->save();
        }

        Session::flash('success', 'You have successfully uploaded the selected job image(s)');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the required model instance.
        $selected_image = JobImage::findOrFail($id);
        // Set The Required Variables.
        // All image types.
        $all_image_types = JobImageType::all();
        // All colours.
        $all_colours = Colour::all();
        // All default image titles.
        $all_default_image_titles = DefaultImageTitle::all();
        // All default image texts.
        $all_default_image_texts = DefaultImageText::all();
        // Return the show view.
        return view('menu.jobs.images.show')
            ->with([
                'selected_image' => $selected_image,
                'all_image_types' => $all_image_types,
                'all_colours' => $all_colours,
                'all_default_image_titles' => $all_default_image_titles,
                'all_default_image_texts' => $all_default_image_texts
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate The Request Data.
        $request->validate([
            'title' => 'sometimes|nullable|string',
            'description' => 'sometimes|nullable|string',
            'image_type_id' => 'required',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);

        // Find the required model instance.
        $selected_image = JobImage::findOrFail($id);

        // Update the selected model instance.
        $selected_image->job_id = $request->job_id;
        $selected_image->job_image_type_id = $request->image_type_id;
        $selected_image->title = ucfirst($request->title);
        $selected_image->colour_id = $request->title_colour;
        $selected_image->description = ucfirst($request->description);
        // Check if new default title has been selected.
        if (isset($request->default_image_title)) {
            // Find the default image text.
            $default_image_title = DefaultImageTitle::find($request->default_image_title);
            // Concatinate the default image text to the title. 
            $selected_image->title = ucfirst($selected_image->title . ' ' . $default_image_title->text);
        }
        // Check if new default text has been selected.
        if (isset($request->default_image_text)) {
            // Find the default image text.
            $default_image_text = DefaultImageText::find($request->default_image_text);
            // Concatinate the default image text to the description. 
            $selected_image->description = ucfirst($selected_image->description . ' ' . $default_image_text->text);
        }
        // Get the image type title
        $selected_image_type = JobImageType::find($request->image_type_id);

        if ($request->hasFile('image')){

            if ($selected_image->image_path != null) {

                if (file_exists(public_path($selected_image->image_path))) {

                    // Delete the previous image if it exists.
                    unlink(public_path($selected_image->image_path));
                }
            }

            // Create the new job image.
            $image = $request->file('image');
            // Create file name from job id, image type and time.
            $filename = Str::slug($selected_image->job_id . ' ' . $selected_image_type->title) . '-' . time() . '.' . $image->getClientOriginalExtension();
            // Create the image path.
            $selected_image->image_path = 'storage/images/jobs/' . $filename;        
            // Create the image location.
            $location = storage_path('app/public/images/jobs/' . $filename);
            // Resize the image and keep the aspect ratio, then save the image.
            Image::make($image)->orientate()->resize(1280, 720)->save($location);

            // Reset the image identifier.
            // Find all job images of the uploaded type.
            $all_job_images = JobImage::where('job_id', $selected_image->job_id)
            ->where('job_image_type_id', $request->image_type)
            ->get();

            // Set an integer to 1 to be incremented in the loop
            $i = 1;

            // Loop through each job image.
            foreach($all_job_images as $selected_job_image) {

                // Update the image identifier.
                $selected_job_image->image_identifier = substr($selected_job_image->job_image_type->title, 0, 1) . ' - ' . $i++;
                $selected_job_image->save();
            }
        }

        // Save the selected model instance.
        $selected_image->save();
        // Return a redirect to the show route.
        return redirect()
            ->route('job-images.show', $id)
            ->with('success', 'You have successfully updated the selected job image.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required model instance.
        $selected_image = JobImage::findOrFail($id);
        // Set The Required Variables.
        // Set the job id.
        $selected_job_id = $selected_image->job_id;
        // Set the job image type id.
        $selected_job_image_type = $selected_image->job_image_type_id;
        // Deleted the image if it exists.
        if ($selected_image->image_path != null) {
            // Check if file exists.
            if (file_exists(public_path($selected_image->image_path))) {
                // Delete the selected job image.
                unlink(public_path($selected_image->image_path));
            }
        }
        // Deleted the selected model instance.
        $selected_image->delete();
        // Reset the image identifier.
        // Find all job images of the uploaded type.
        $all_job_images = JobImage::where('job_id', $selected_job_id)
            ->where('job_image_type_id', $selected_job_image_type)
            ->get();
        // If there are images remaining with the same image type.
        if ($all_job_images != null) {
            // Set an integer to 1.
            $i = 1;
            // Loop through each job image.
            foreach($all_job_images as $selected_job_image) {
                // Update the image identifier using the first letter of the title and the integer.
                $selected_job_image->image_identifier = substr($selected_job_image->job_image_type->title, 0, 1) . ' - ' . $i++;
                $selected_job_image->save();
            }
        }
        // Return a redirect to the create view.
        return redirect()
            ->route('job-images.create', ['job_id' => $selected_job_id])
            ->with('success', 'You have successfully deleted the selected job image.');
    }
}
