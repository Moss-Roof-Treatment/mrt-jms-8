<?php

namespace App\Http\Controllers\Menu\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleTag;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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

        // Create a new model instance.
        $new_tag = new ArticleTag;
        $new_tag->title = $request->title;
        $new_tag->slug = Str::slug($request->title);

        if (isset($request->image)) {
            $image = $request->file('image');
            $filename = Str::slug($request->title) . '-image' . '.' . $image->getClientOriginalExtension();
            $new_tag->image_path = 'storage/images/content/tags/' . $filename;
            $location = storage_path('app/public/images/content/tags/' . $filename);
            Image::make($image)->orientate()->resize(256, 256)->save($location);
        }

        $new_tag->save();

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

        // Update the selected model instance.
        $selected_tag->title = $request->title;
        $selected_tag->slug = Str::slug($request->title);

        if (isset($request->image)) {
            // Check if the selected model instance image path is not empty.
            if ($selected_tag->image_path != null) {
                // Check if the file exists on the server.
                if (file_exists(public_path($selected_tag->image_path))) {
                    // Delete the selected image.
                    unlink(public_path($selected_tag->image_path));
                }
            }
            // Create the new image.
            $image = $request->file('image');
            $filename = Str::slug($request->title) . '-image' . '.' . $image->getClientOriginalExtension();
            $selected_tag->image_path = 'storage/images/content/tags/' . $filename;
            $location = storage_path('app/public/images/content/tags/' . $filename);
            Image::make($image)->orientate()->resize(256, 256)->save($location);
        }

        $selected_tag->save();

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

        // Delete the required image from the server.

        // Check if the selected model instance image path is not empty.
        if ($selected_tag->image_path != null) {
            // Check if the file exists on the server.
            if (file_exists(public_path($selected_tag->image_path))) {
                // Delete the selected image.
                unlink(public_path($selected_tag->image_path));
            }
        }

        // Delete the selected model instance.
        $selected_tag->delete();

        // Return a redirect to the index route.
        return redirect()
            ->route('content-tags.index')
            ->with('success', 'You have successfully deleted the selected content tag.');
    }
}
