<?php

namespace App\Http\Controllers\Menu\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ArticleImage;
use Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        // Check the request data for the required file.
        if ($request->hasFile('file')) {
            // Check if any images already exist.
            $selected_article->article_images()->exists()
                ? $i = $selected_article->article_images()->count() + 1
                : $i = 1;
            // Loop through each uploaded image.
            foreach($request->file('image') as $image){
                 // Set the new file name.
                $filename = Str::slug($selected_article->title) . '-image-' . $i . '-' . time() . '.' . $image->getClientOriginalExtension();
                // Set the new file location.
                $location = storage_path('app/public/images/content/blogs/' . $filename);
                // Create new manager instance with desired driver.
                $manager = new ImageManager(new Driver());
                // Read image from filesystem
                $image = $manager->read($image);
                // Encoding jpeg data
                $image->resize(1280, 720)->toJpeg(80)->save($location);
                // Create the new model instance.
                ArticleImage::create([
                    'article_id' => $selected_article->id,
                    'image_path' => 'storage/images/content/blogs/' . $filename,
                    'staff_id' => Auth::id(),
                    'is_featured' => $i == 1 ? 1 : 0
                ]);
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
        // Find the required model instance.
        $selected_article_image = ArticleImage::findOrFail($id);
        // Check if a new image has been uploaded.
        if ($request->hasFile('image')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_article_image->image_path != null && file_exists(public_path($selected_article_image->image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_article_image->image_path));
            }
            // Check if any images already exist.
            $selected_article_image->article->article_images()->exists()
                ? $i = $selected_article_image->article->article_images()->count() + 1
                : $i = 1;
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::slug($selected_article_image->article->title) . '-image-' . $i . '-' . time() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/content/blogs/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(1280, 720)->toJpeg(80)->save($location);
            // Formatted path for database.
            $new_image_path = 'storage/images/content/blogs/' . $filename;
        };
        // Update the selected model instance.
        $selected_article_image->update([
            'is_visible' => $request->is_visible,
            'is_featured' => $request->is_featured,
            'alt_tag_label' => $request->alt_tag_label,
            'description' => $request->description,
            'image_path' => isset($new_image_path) ? $new_image_path : $selected_article_image->image_path
        ]);
        // Check if the featured status has been set.
        if ($selected_article_image->is_featured == 1) {
            // Get all related article images that are not set to featured.
            $non_featured_images = ArticleImage::where('article_id', $selected_article_image->article_id)
                ->where('id', '!=', $selected_article_image->id)
                ->get();
            // Set all other images to not featured.
            foreach($non_featured_images as $image) {
                $image->update([
                    'is_featured' => 0
                ]);
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
        // Find the required model instance.
        $selected_article_image = ArticleImage::findOrFail($id);
        // Find the related article.
        $selected_article = Article::find($selected_article_image->article_id);
        // Set a variable if the image is featured.
        $selected_article_image->is_featured == 0 ? $featured_status = 0 : $featured_status = 1;
        // Check if the file path value is not null and file exists on the server.
        if ($selected_article_image->image_path != null && file_exists(public_path($selected_article_image->image_path))) {
            // Delete the file from the server.
            unlink(public_path($selected_article_image->image_path));
        }
        // Delete the selected model instance.
        $selected_article_image->delete();
        // Check for existing related images.
        if ($selected_article->article_images()->exists() && $featured_status == 1) {
            // First related image.
            $new_featured_image = ArticleImage::where('article_id', $selected_article->id)
                ->first();
            // Set featured status.
            $new_featured_image->update([
                'is_featured' => 1
            ]);
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('blogs.show', $selected_article->id)
            ->with('success', 'You have successfully deleted the selected blog image.');
    }
}
