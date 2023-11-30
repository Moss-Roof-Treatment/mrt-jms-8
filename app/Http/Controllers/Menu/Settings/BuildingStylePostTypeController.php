<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuildingStylePostType;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BuildingStylePostTypeController extends Controller
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
        $all_building_style_post_types = BuildingStylePostType::get();
        // Return the index view.
        return view('menu.settings.buildingStylePostTypes.index')
            ->with('all_building_style_post_types', $all_building_style_post_types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.buildingStylePostTypes.create');
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
            'title' => 'required|min:5|max:255|unique:building_styles,title',
            'description' => 'required|min:5|max:500',
            'image_path' => 'required|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Create the new model instance.
        $new_building_style_type = BuildingStylePostType::create([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Create the new image if required.
        if (isset($request->image_path)) {
            $image = $request->file('image_path');
            $filename = Str::slug($request->title) . 'type' . '.' . $image->getClientOriginalExtension();
            $new_building_style_type->image_path = 'storage/images/buildingStylePostTypes/' . $filename;
            $location = storage_path('app/public/images/buildingStylePostTypes/' . $filename);
            Image::make($image)->orientate()->resize(1280, 720)->save($location);
        }
        // Save and update the new model instance.
        $new_building_style_type->save();
        // Return a redirect to the show route.
        return redirect()
            ->route('building-style-post-t-settings.show', $new_building_style_type->id)
            ->with('success', 'You have successfully created a new building style.');
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
        $selected_building_style_post_type = BuildingStylePostType::findOrFail($id);
        // Return the show view.
        return view('menu.settings.buildingStylePostTypes.show')
            ->with('selected_building_style_post_type', $selected_building_style_post_type);
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
        $selected_building_style_post_type = BuildingStylePostType::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.buildingStylePostTypes.edit')
            ->with('selected_building_style_post_type', $selected_building_style_post_type);
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
            'title' => 'required|min:5|max:255|unique:building_styles,title',
            'description' => 'required|min:5|max:500',
            'image_path' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Find the required model instance.
        $selected_building_style_post_type = BuildingStylePostType::findOrFail($id);
        // Update the selected model instance.
        $selected_building_style_post_type->title = ucwords($request->title);
        $selected_building_style_post_type->description = ucwords($request->description);
        // Create the new image if required.
        if (isset($request->image_path)) {
            // Check if the selected model instance image path is not empty.
            if ($selected_building_style_post_type->image_path != null) {
                // Check if the file exists on the server.
                if (file_exists(public_path($selected_building_style_post_type->image_path))) {
                    // Delete the selected image.
                    unlink(public_path($selected_building_style_post_type->image_path));
                }
            }
            // Create the new image.
            $image = $request->file('image_path');
            $filename = Str::slug($request->title) . 'type' . '.' . $image->getClientOriginalExtension();
            $selected_building_style_post_type->image_path = 'storage/images/buildingStylePostTypes/' . $filename;
            $location = storage_path('app/public/images/buildingStylePostTypes/' . $filename);
            Image::make($image)->orientate()->resize(1280, 720)->save($location);
        }
        // Save and update the new model instance.
        $selected_building_style_post_type->save();
        // Return a redirect to the show route.
        return redirect()
            ->route('building-style-post-t-settings.show', $selected_building_style_post_type->id)
            ->with('success', 'You have successfully updated the selected building style post.');
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
        $selected_building_style_post_type = BuildingStylePostType::findOrFail($id);
        // Delete the required image from the server.
        // Check if the selected model instance image path is not empty.
        if ($selected_building_style_post_type->image_path != null) {
            // Check if the file exists on the server.
            if (file_exists(public_path($selected_building_style_post_type->image_path))) {
                // Delete the selected image.
                unlink(public_path($selected_building_style_post_type->image_path));
            }
        }
        // Check if the selected model instance has and relationships
        if ($selected_building_style_post_type->building_style_posts()->exists()) {
            // Loop through each image.
            foreach($selected_building_style_post_type->building_style_posts as $post) {
                // Check if the selected model instance image path is not empty.
                if ($post->image_path != null) {
                    // Check if the file exists on the server.
                    if (file_exists(public_path($post->image_path))) {
                        // Delete the selected image.
                        unlink(public_path($post->image_path));
                    }
                }
                // Delete the relationship model instance.
                $post->delete();
            }
        }
        // Delete the selected model instance.
        $selected_building_style_post_type->delete();
        // Return a redirect to index route.
        return redirect()
            ->route('building-style-post-t-settings.index')
            ->with('success', 'You have successfully deleted the selected building style post.');
    }
}
