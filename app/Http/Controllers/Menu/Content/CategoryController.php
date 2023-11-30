<?php

namespace App\Http\Controllers\Menu\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
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
        $all_categories = ArticleCategory::get();
        // Return the index view.
        return view('menu.content.categories.index')
            ->with('all_categories', $all_categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.content.categories.create');
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
            'title' => 'required|min:5|max:255|unique:article_categories,title',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);

        // Create the new model instance.
        $new_category = ArticleCategory::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ]);

        // Create the new image if required.
        if (isset($request->image)) {
            $image = $request->file('image');
            $filename = Str::slug($request->title) . '-image' . '.' . $image->getClientOriginalExtension();
            $new_category->image_path = 'storage/images/content/categories/' . $filename;
            $location = storage_path('app/public/images/content/categories/' . $filename);
            Image::make($image)->orientate()->resize(256, 256)->save($location);
        }

        $new_category->save();

        // Return a redirect to the show route.
        return redirect()
            ->route('content-categories.show', $new_category->id)
            ->with('success', 'You have successfully created a new content category.');
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
        $category = ArticleCategory::findOrFail($id);
        // Return the show view.
        return view('menu.content.categories.show')
            ->with('category', $category);
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
        $category = ArticleCategory::findOrFail($id);
        // Return the edit view.
        return view('menu.content.categories.edit')
            ->with('category', $category);
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
            'title' => 'required|min:5|max:255|unique:article_categories,title,'.$id,
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);

        // Find the required model instance.
        $selected_category = ArticleCategory::findOrFail($id);

        // Update the selected model instance.
        $selected_category->title = $request->title;
        $selected_category->slug = Str::slug($request->title);

        if (isset($request->image)) {
            // Check if the selected model instance image path is not empty.
            if ($selected_category->image_path != null) {
                // Check if the file exists on the server.
                if (file_exists(public_path($selected_category->image_path))) {
                    // Delete the selected image.
                    unlink(public_path($selected_category->image_path));
                }
            }
            // Create the new image.
            $image = $request->file('image');
            $filename = Str::slug($request->title) . '-image' . '.' . $image->getClientOriginalExtension();
            $selected_category->image_path = 'storage/images/content/categories/' . $filename;
            $location = storage_path('app/public/images/content/categories/' . $filename);
            Image::make($image)->orientate()->resize(256, 256)->save($location);
        }

        $selected_category->save();

        // Return a redirect to the show route.
        return redirect()
            ->route('content-categories.show', $id)
            ->with('success', 'You have successfully updated the selected content category.');
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
        $selected_category = ArticleCategory::findOrFail($id);

        // Delete the required image from the server.
        // Check if the selected model instance image path is not empty.
        if ($selected_category->image_path != null) {
            // Check if the file exists on the server.
            if (file_exists(public_path($selected_category->image_path))) {
                // Delete the selected image.
                unlink(public_path($selected_category->image_path));
            }
        }

        // Delete the selected model instance.
        $selected_category->delete();

        // Return a redirect to the index route.
        return redirect()
            ->route('content-categories.index')
            ->with('success', 'You have successfully deleted the selected content category.');
    }
}
