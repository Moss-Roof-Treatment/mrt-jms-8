<?php

namespace App\Http\Controllers\Menu\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\ArticleImage;
use Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Session;

class ArticleDropzoneController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Set the selected inspection id variable and save the uploaded images.
        |--------------------------------------------------------------------------
        */

        $selected_article = Article::find($request->article_id);
        // Check if the file exists in the request data.
        if ($request->hasFile('file')) {

            // Set an int for the photo count.
            if ($selected_article->article_images()->exists()) {
                $i = $selected_article->article_images()->count() + 1;
            } else {
                $i = 1; 
            }
            // Create the new image.
            $image = $request->file('file');

            // New model instance.
            $new_article_image = new ArticleImage;

            // Assign data to the image.
            $new_article_image->article_id = $selected_article->id;
            $new_article_image->staff_id = Auth::id();

            // Assign featured status if the current image count variable equals 1.
            if ($i == 1) {
                $new_article_image->is_featured = 1;
            }

            // Use the integer for the name without change.
            $filename = Str::slug($selected_article->title) . '-image-' . $i . '-' . time() . '.' . $image->getClientOriginalExtension();
            $new_article_image->image_path = 'storage/images/content/articles/' . $filename;
            $location = storage_path('app/public/images/content/articles/' . $filename);
            Image::make($image)->orientate()->resize(1280, 720)->save($location);

            // Save The new job image.
            $new_article_image->save();
        }

        Session::flash('success', 'You have successfully uploaded the selected article image(s).');
    }
}
