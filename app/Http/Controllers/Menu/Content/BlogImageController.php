<?php

namespace App\Http\Controllers\Menu\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ArticleImage;
use Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BlogImageController extends Controller
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
        $selected_article = Article::find($_GET['selected_article_id']);
        // Return the create view.
        return view('menu.content.blogs.images.create')
            ->with('selected_article', $selected_article);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate The Request Data.
        $request->validate([
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);

        // Find the required model instance.
        $selected_article = Article::find($request->article_id);

        // Create the new model relationship instances.
        // Check if the file exists in the request data.
        if ($request->hasFile('image')) {
            // Set an int for the photo count.
            if ($selected_article->article_images()->exists()) {
                $i = $selected_article->article_images()->count() + 1;
            } else {
                $i = 1; 
            }
            // Loop through each uploaded image.
            foreach($request->file('image') as $image){
                // New model instance.
                $new_article_image = new ArticleImage;
                // Assign data to the image.
                $new_article_image->article_id = $selected_article->id;
                $new_article_image->staff_id = Auth::id();
                // Assign featured status if the current image count variable equals 1.
                if ($i == 1) {
                    // Set the featured status.
                    $new_article_image->is_featured = 1;
                }
                // Use the integer for the name without change.
                $filename = Str::slug($selected_article->title) . '-image-' . $i . '-' . time() . '.' . $image->getClientOriginalExtension();
                $new_article_image->image_path = 'storage/images/content/blogs/' . $filename;
                $location = storage_path('app/public/images/content/blogs/' . $filename);
                Image::make($image)->orientate()->resize(1280, 720)->save($location);
                // Save The new article image.
                $new_article_image->save();
                // Increment the i variable for the next round of looping.
                $i++;
            }
        }

        // Return a redirect back.
        return back()
            ->with('success', 'You have successfully uploaded the selected blog image(s).');
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
        $selected_article_image = ArticleImage::findOrFail($id);
        // Return the show view.
        return view('menu.content.blogs.images.show')
            ->with('selected_article_image', $selected_article_image);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find the required model instance.
        $selected_article_image = ArticleImage::findOrFail($id);
        // Return the edit view.
        return view('menu.content.blogs.images.edit')
            ->with('selected_article_image', $selected_article_image);
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
            'description' => 'sometimes|nullable|string|min:10|max:1000',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);

        // Find and update the selected model instance.
        $selected_article_image = ArticleImage::findOrFail($id);
        $selected_article_image->is_visible = $request->is_visible;
        $selected_article_image->is_featured = $request->is_featured;
        $selected_article_image->alt_tag_label = $request->alt_tag_label;
        $selected_article_image->description = $request->description;

        // Update the image if required.
        if (isset($request->image)) {
            // Check if image path exists.
            if ($selected_article_image->image_path != null) {
                // Check if image file exists.
                if (file_exists(public_path($selected_article_image->image_path))) {
                    // Delete the selected image.
                    unlink(public_path($selected_article_image->image_path));
                }
            }

            // Get the image data from the request.
            $image = $request->file('image_path');

            // Set an int for the photo count.
            if ($selected_article_image->article->article_images()->exists()) {
                $i = $selected_article_image->article->article_images()->count() + 1;
            }

            // Use the integer for the name without change.
            $filename = Str::slug($selected_article_image->article->title) . '-image-' . $i . '-' . time() . '.' . $image->getClientOriginalExtension();
            $selected_article_image->image_path = 'storage/images/content/blogs/' . $filename;
            $location = storage_path('app/public/images/content/blogs/' . $filename);
            Image::make($image)->orientate()->resize(1280, 720)->save($location);
        }

        // Save the model instance.
        $selected_article_image->save();

        // Set featured image status is required.
        // if the selected article image is set to featured.
        if ($selected_article_image->is_featured == 1) {

            // Find all article images that are not the one set to featured.
            $other_images = ArticleImage::where('article_id', $selected_article_image->article_id)
                ->where('id', '!=', $selected_article_image->id)
                ->get();

            // Loop through each article image.
            foreach($other_images as $image) {

                // Set the featured status to 0.
                $image->is_featured = 0;
                $image->save();
            }
        }

        // Return a redirect to the show page.
        return redirect()
            ->route('blogs-images.show', $selected_article_image)
            ->with('success', 'You have successfully updated the selected blog image.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the required article image.
        $selected_article_image = ArticleImage::findOrFail($id);

        // Find the required article.
        $selected_article = Article::find($selected_article_image->article_id);

        // Set a variable if the image is featured.
        if ($selected_article_image->is_featured == 0) {
            // The selected image is not the featured image.
            $featured_status = 0;
        } else {
            // The selected image is the featured image.
            $featured_status = 1;
        }

        // Check that the image path exists in the database.
        if ($selected_article_image->image_path != null) {
            // Delete the selected image from storage.
            if (file_exists(public_path($selected_article_image->image_path))) {
                // Delete the selected image.
                unlink(public_path($selected_article_image->image_path));
            }
        }

        $selected_article_image->delete();

        // Set new featured image if required.

        // If there are still images set the first one as the featured image.
        if ($selected_article->article_images()->exists()) {
            // Set a new featured image if required.
            if ($featured_status == 1) {
                // Find the first image in the database.
                $new_featured_image = ArticleImage::where('article_id', $selected_article->id)
                    ->first();
                // Set featured status.
                $new_featured_image->update([
                    'is_featured' => 1
                ]);
            }
        }

        // Return a redirect to the show route.
        return redirect()
            ->route('blogs.show', $selected_article->id)
            ->with('success', 'You have successfully deleted the selected blog image.');
    }
}
