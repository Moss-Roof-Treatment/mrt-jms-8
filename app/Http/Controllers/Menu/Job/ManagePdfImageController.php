<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobImage;

class ManagePdfImageController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Set The Required Variables.
        // Find the required job.
        $selected_job = Job::findOrFail($id);
        // Find all the required job images.
        $selected_job_images = JobImage::where('job_id', $id)
            ->get();
        // Selected job images grouped by image type.
        $image_type_collections = $selected_job_images->groupBy('job_image_type_id');
        // Return the show view.
        return view('menu.jobs.images.pdfImages.show')
            ->with([
                'selected_job' => $selected_job,
                'image_type_collections' => $image_type_collections
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
            'images' => 'required|array|between:1,4'
        ]);
        // Set The Required Variables.
        // Find all job images.
        $all_images = JobImage::where('job_id', $id)->get();
        // Set all images as not visible.
        foreach($all_images as $image) {
            $image->update([
                'is_pdf_image' => 0
            ]);
        }
        // Find selected images.
        $selected_images = JobImage::find($request->images);
        // Loop through each selected image.
        foreach($selected_images as $image) {
            // Set image as visible.
            $image->update([
                'is_pdf_image' => 1
            ]);
        }
        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected job PDF images.');
    }
}
