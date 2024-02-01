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
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
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
        // Get the image type title.
        $selected_image_type = JobImageType::find($request->image_type);
        // Check the request data for the required file.
        if ($request->hasFile('file')) {
            // Create the new model instance.
            $new_job_image = JobImage::create([
                'job_id' => $selected_job_id,
                'staff_id' => Auth::id(),
                'job_image_type_id' => $request->image_type,
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
            // RESET THE IMAGE IDENTIFIER
            // Find all job images of the uploaded type.
            $all_job_images = JobImage::where('job_id', $selected_job_id)
                ->where('job_image_type_id', $request->image_type)
                ->get();
            // Set an integer to 1 to be incremented in the loop
            $i = 1;
            // Loop through each job image.
            foreach($all_job_images as $selected_job_image) {
                // Update the image identifier.
                $selected_job_image->update([
                    'image_identifier' => substr($selected_job_image->job_image_type->title, 0, 1) . ' - ' . $i++
                ]);
            }
        }
        // Flash success message to the session.
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
        // Set the required variables.
        // Default image title.
        if (isset($request->default_image_title)) {
            // Find the default image title.
            $default_image_title = DefaultImageTitle::find($request->default_image_title);
            // Concatinate the default image text to the title. 
            $new_image_title = ucfirst($selected_image->title . ' ' . $default_image_title->text);
        }
        // Default image text.
        if (isset($request->default_image_text)) {
            // Find the default image text.
            $default_image_text = DefaultImageText::find($request->default_image_text);
            // Concatinate the default image text to the description. 
            $new_image_text = ucfirst($selected_image->description . ' ' . $default_image_text->text);
        }
        // Check if a new image has been uploaded.
        if ($request->hasFile('image')) {
            // Get the image type title
            $selected_image_type = JobImageType::find($request->image_type_id);
            // Check if the file path value is not null and file exists on the server.
            if ($selected_image->image_path != null && file_exists(public_path($selected_image->image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_image->image_path));
            }
            // Create the new job image.
            $image = $request->file('image');
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
            // Formatted path for database.
            $new_image_path = 'storage/images/jobs/' . $filename;
            // RESET THE IMAGE IDENTIFIER
            // Find all job images of the uploaded type.
            $all_job_images = JobImage::where('job_id', $selected_image->job_id)
                ->where('job_image_type_id', $request->image_type)
                ->get();
            // Set an integer to 1 to be incremented in the loop
            $i = 1;
            // Loop through each job image.
            foreach($all_job_images as $selected_job_image) {
                // Update the image identifier.
                $selected_job_image->update([
                    'image_identifier' => substr($selected_job_image->job_image_type->title, 0, 1) . ' - ' . $i++
                ]);
            }
        };
        // Update the selected model instance.
        $selected_image->update([
            'job_id' => $request->job_id,
            'job_image_type_id' => $request->image_type_id,
            'title' => isset($new_image_title) ? $new_image_title : $selected_image->title,
            'colour_id' => $request->title_colour,
            'description' => isset($new_image_text) ? $new_image_text : $selected_image->description,
            'image_path' => isset($new_image_path) ? $new_image_path : $selected_image->image_path
        ]);
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
