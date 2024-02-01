<?php

namespace App\Http\Controllers\Menu\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleTag;
use Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TagController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Find all of the required model instances.
        $all_tags = ArticleTag::get();
        // Return the index view.
        return view('menu.content.tags.index')
            ->with('all_tags', $all_tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.content.tags.create');
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
            'title' => 'required|min:5|max:255|unique:article_tags,title',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Create the new image if required.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/content/tags/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
        }
        // Create the new model instance.
        $new_tag = ArticleTag::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'image_path' => 'storage/images/content/tags/' . $filename,
            'staff_id' => Auth::id(),
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('content-tags.show', $new_tag->id)
            ->with('success', 'You have successfully created a new content tag.');
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
        $tag = ArticleTag::findOrFail($id);
        // Return the show view.
        return view('menu.content.tags.show')
            ->with('tag', $tag);
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
        $tag = ArticleTag::findOrFail($id);
        // Return the edit view.
        return view('menu.content.tags.edit')
            ->with('tag', $tag);
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
            'title' => 'required|min:5|max:255|unique:article_tags,title,'.$id,
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Find the required model instance.
        $selected_tag = ArticleTag::findOrFail($id);
        // Check if a new image has been uploaded.
        if ($request->hasFile('image')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_tag->image_path != null && file_exists(public_path($selected_tag->image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_tag->image_path));
            }
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/content/tags/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
        }
        // Update the selected model instance.
        $selected_tag->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'image_path' => 'storage/images/content/tags/' . $filename,
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('content-tags.show', $id)
            ->with('success', 'You have successfully updated the selected content tag.');
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
        $selected_tag = ArticleTag::findOrFail($id);
        // Check if the file path value is not null and file exists on the server.
        if ($selected_tag->image_path != null && file_exists(public_path($selected_tag->image_path))) {
            // Delete the file from the server.
            unlink(public_path($selected_tag->image_path));
        }
        // Delete the selected model instance.
        $selected_tag->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('content-tags.index')
            ->with('success', 'You have successfully deleted the selected content tag.');
    }
}
