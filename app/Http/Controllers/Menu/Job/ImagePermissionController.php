<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use App\Mail\Customer\NewJobImages;
use App\Models\Job;
use App\Models\JobImage;
use App\Models\Note;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ImagePermissionController extends Controller
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Set The Required Variables.
        // Find the required job. 
        $selected_job = Job::find($request->job_id);
        // Find all job images.
        $all_images = JobImage::where('job_id', $request->job_id)->get();

        // Validate incoming request.
        // Check if the job has any images uploaded.
        if (!$all_images->count()) {
            // redirect back as there are no images to update.
            return back()
                ->with('danger', 'There are no images uploaded for this job. Please upload at least one image before atempting to update the visibility of uploaded job images.');
        }
        // Update the selected model instances.
        // Check if any images where selected.
        if ($request->checked != null) {
            // Find the id of all the selected images.
            $selected_images = JobImage::find($request->checked)->pluck('id')->toArray();
            // Loop through each image and change the visibility as required.
            foreach($all_images as $image) {
                // Check if the selected image id exists within the checked array. 
                if (in_array($image->id, $selected_images)) {
                    // The selected image exists in the array, set image to visible.
                    $image->is_visible = 1;
                    $image->save();
                } else {
                    // The selected image does not exist in the array, set image to not visible.
                    // As the image is not visible remove pdf status if required.
                    $image->is_pdf_image = 0;
                    $image->is_visible = 0;
                    $image->save();
                }
            }
        } else {
            // Loop through each image and change the visibility to not visible.
            foreach($all_images as $image) {
                // The selected image does not exist in the array, set image to not visible.
                // As the image is not visible remove pdf status if required.
                $image->is_pdf_image = 0;
                $image->is_visible = 0;
                $image->save();
            }
        }

        // Send email.
        if ($request->notify_customer_via_email != null && $selected_job->customer->email != null) {
            // Create the data array to populate the emails with.
            $data = [
                'recipient_name' => $selected_job->customer->getFullNameAttribute(),
                'job_id' => $selected_job->id
            ];
            // Check if the selected quote customer has an email address.
            if ($selected_job->customer->email != null) {
                // Send the driveby inspection email.
                Mail::to($selected_job->customer->email)
                    ->send(new NewJobImages($data));
            }
            // Create the new note.
            Note::create([
                'sender_id' => Auth::id(),
                'job_id' => $selected_job->id,
                'text' => '"New Job Image" email sent to customer. - ' . Auth::user()->getFullNameAttribute() . '.',
                'is_internal' => 1,
                'jms_seen_at' => Carbon::now(),
                'jms_acknowledged_at' => Carbon::now()
            ]);
            // Return a redirect back.
            return back()
                ->with('success', 'You have successfully updated the selected job image permissions and sent a "New Job Image" email to the selected customer.');
        }

        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected job image permissions.');
    }
}
