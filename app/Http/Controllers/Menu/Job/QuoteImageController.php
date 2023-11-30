<?php

namespace App\Http\Controllers\Menu\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\JobImage;
use App\Models\JobImageQuote;

class QuoteImageController extends Controller
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
        // Validation.
        // Check if the required GET variable has not been supplied in the URL.
        if (!isset($_GET['quote_id'])) {
            // The Get variable was not supplied in the URL.
            // Return a 404.
            return abort(404);
        }
        // Set The Required Variables.
        // Selected job image.
        $selected_quote = Quote::find($_GET['quote_id']);
        // Selected job images.
        $job_images = JobImage::where('job_id', $selected_quote->job_id)->get();
        // Selected job images grouped by image type.
        $image_type_collections = $job_images->groupBy('job_image_type_id');
        // Find the job_image_quote model instances.
        $quote_images = JobImageQuote::where('quote_id', $selected_quote->id)
            ->pluck('job_image_id')
            ->toArray();
        // All quotes.
        $all_quote_ids = Quote::where('job_id', $selected_quote->job_id)
            ->pluck('id')
            ->toArray();
        // Return a redirect to the create page.
        return view('menu.jobs.images.quoteImages.create')
            ->with([
                'all_quote_ids' => $all_quote_ids,
                'image_type_collections' => $image_type_collections,
                'job_images' => $job_images,
                'quote_images' => $quote_images,
                'selected_quote' => $selected_quote
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
        // Find the required quote.
        $selected_quote = Quote::find($id);
        // Update the tags relationship instances.
        if (isset($request->checked)) {
            $selected_quote->job_image_quotes()->sync($request->checked);
        } else {
            $selected_quote->job_image_quotes()->sync(array());
        }
        // Return a redirect back with success message.
        return back()
            ->with('success', 'You have successfully updated the selected quote images.');
    }
}
