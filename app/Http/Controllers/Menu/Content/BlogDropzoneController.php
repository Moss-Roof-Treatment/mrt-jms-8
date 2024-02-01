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
use Session;

class BlogDropzoneController extends Controller
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
        // Find the required model instance.
        $selected_article = Article::find($request->article_id);
        // Check the request data for the required file.
        if ($request->hasFile('file')) {
            // Check if any images already exist.
            $selected_article->article_images()->exists()
                ? $i = $selected_article->article_images()->count() + 1
                : $i = 1;
            // Set the uploaded file.
            $image = $request->file('file');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
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
        }
        // Flash success message to the session.
        Session::flash('success', 'You have successfully uploaded the selected blog image(s).');
    }
}
