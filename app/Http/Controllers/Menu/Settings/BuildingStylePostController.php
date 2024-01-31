<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuildingStylePost;
use App\Models\BuildingStylePostType;
use App\Models\MaterialType;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BuildingStylePostController extends Controller
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
        $all_building_style_posts = BuildingStylePost::get();
        // Return the index view.
        return view('menu.settings.buildingStylePosts.index')
            ->with('all_building_style_posts', $all_building_style_posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // All material types.
        $all_building_types = BuildingStylePostType::all('id', 'title');
        // All material types.
        $all_material_types = MaterialType::all('id', 'title');
        // Return the create view.
        return view('menu.settings.buildingStylePosts.create')
            ->with([
                'all_building_types' => $all_building_types,
                'all_material_types' => $all_material_types
            ]);
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
            'building_style_post_type_id' => 'required',
            'material_type_id' => 'required',
            'title' => 'required|min:5|max:255|unique:building_styles,title',
            'description' => 'sometimes|nullable|string|min:10|max:1000',
            'roof_outline_image_path' => 'required|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'building_image_path' => 'required|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'completed_date' => 'required',
        ]);
        // Create the new model instance.
        $new_building_style = BuildingStylePost::create([
            'building_style_post_type_id' => $request->building_style_post_type_id,
            'material_type_id' => $request->material_type_id,
            'title' => ucwords($request->title),
            'description' => ucfirst($request->description),
            'completed_date' => Carbon::parse($request->completed_date)
        ]);
        // Create the new image if required.
        if ($request->hasFile('roof_outline_image_path')) {
            // Set the uploaded file.
            $image = $request->file('roof_outline_image_path');
            // Set the new file name.
            $filename = Str::slug($request->title) . 'roof-image' . '.' . $image->getClientOriginalExtension();
            // Set the new path variable.
            $new_roof_outline_image_path = 'storage/images/buildingStylePosts/' . $filename;
            // Set the new file location.
            $location = storage_path('app/public/images/buildingStylePosts/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(1280, 720)->toJpeg(80)->save($location);
        }
        // Create the new image if required.
        if ($request->hasFile('building_image_path')) {
            // Set the uploaded file.
            $image = $request->file('building_image_path');
            // Set the new file name.
            $filename = Str::slug($request->title) . 'building-image' . '.' . $image->getClientOriginalExtension();
            // Set the new path variable.
            $new_building_image_path = 'storage/images/buildingStylePosts/' . $filename;
            // Set the new file location.
            $location = storage_path('app/public/images/buildingStylePosts/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(1280, 720)->toJpeg(80)->save($location);
        }
        // Save and update the new model instance.
        $new_building_style->update([
            'roof_outline_image_path' => isset($new_roof_outline_image_path) ? $new_roof_outline_image_path : $new_building_style->roof_outline_image_path,
            'building_image_path' => isset($new_building_image_path) ? $new_building_image_path : $new_building_style->building_image_path,
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('building-style-post-settings.show', $new_building_style->id)
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
        $selected_building_style_post = BuildingStylePost::findOrFail($id);
        // Set The Required Variables.
        // All material types.
        $all_material_types = MaterialType::all('id', 'title');
        // Return the show view.
        return view('menu.settings.buildingStylePosts.show')
            ->with([
                'selected_building_style_post' => $selected_building_style_post,
                'all_material_types' => $all_material_types
            ]);
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
        $selected_building_style_post = BuildingStylePost::findOrFail($id);
        // Set The Required Variables.
        // All material types.
        $all_building_types = BuildingStylePostType::all('id', 'title');
        // All material types.
        $all_material_types = MaterialType::all('id', 'title');
        // Return the edit view.
        return view('menu.settings.buildingStylePosts.edit')
            ->with([
                'selected_building_style_post' => $selected_building_style_post,
                'all_building_types' => $all_building_types,
                'all_material_types' => $all_material_types
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
        // Validate The Request Data.
        $request->validate([
            'building_style_post_type_id' => 'required',
            'material_type_id' => 'required',
            'title' => 'required|min:5|max:255|unique:building_styles,title',
            'description' => 'sometimes|nullable|string|min:10|max:1000',
            'roof_outline_image_path' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'building_image_path' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
            'completed_date' => 'required',
        ]);
        // Find the required model instance.
        $selected_building_style_post = BuildingStylePost::findOrFail($id);
        // Update the selected model instance.
        $selected_building_style_post->update([
            'building_style_post_type_id' => $request->building_style_post_type_id,
            'material_type_id' => $request->material_type_id,
            'title' => ucwords($request->title),
            'description' => ucfirst($request->description),
            'completed_date' => Carbon::parse($request->completed_date),
        ]);
        // Check the request data for the required file.
        if ($request->hasFile('roof_outline_image_path')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_building_style_post->roof_outline_image_path != null && file_exists(public_path($selected_building_style_post->roof_outline_image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_building_style_post->roof_outline_image_path));
            }
            // Set the uploaded file.
            $image = $request->file('roof_outline_image_path');
            // Set the new file name.
            $filename = Str::slug($request->title) . 'roof-image' . '.' . $image->getClientOriginalExtension();
            // Set the new path variable.
            $new_roof_outline_image_path = 'storage/images/buildingStylePosts/' . $filename;
            // Set the new file location.
            $location = storage_path('app/public/images/buildingStylePosts/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(1280, 720)->toJpeg(80)->save($location);
        }
        // Check the request data for the required file.
        if ($request->hasFile('building_image_path')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_building_style_post->building_image_path != null && file_exists(public_path($selected_building_style_post->building_image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_building_style_post->building_image_path));
            }
            // Set the uploaded file.
            $image = $request->file('building_image_path');
            // Set the new file name.
            $filename = Str::slug($request->title) . 'building-image' . '.' . $image->getClientOriginalExtension();
            // Set the new path variable.
            $new_building_image_path = 'storage/images/buildingStylePosts/' . $filename;
            // Set the new file location.
            $location = storage_path('app/public/images/buildingStylePosts/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(1280, 720)->toJpeg(80)->save($location);
        }
        // Save and update the new model instance.
        $selected_building_style_post->update([
            'roof_outline_image_path' => isset($new_roof_outline_image_path) ? $new_roof_outline_image_path : $selected_building_style_post->roof_outline_image_path,
            'building_image_path' => isset($new_building_image_path) ? $new_building_image_path : $selected_building_style_post->building_image_path,
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('building-style-post-settings.show', $selected_building_style_post->id)
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
        $selected_building_style_post = BuildingStylePost::findOrFail($id);
        // Delete the required image from the server.
        // Check if the selected model instance image path is not empty.
        if ($selected_building_style_post->roof_outline_image_path != null) {
            // Check if the file exists on the server.
            if (file_exists(public_path($selected_building_style_post->roof_outline_image_path))) {
                // Delete the selected image.
                unlink(public_path($selected_building_style_post->roof_outline_image_path));
            }
        }
        // Check if the selected model instance image path is not empty.
        if ($selected_building_style_post->building_image_path != null) {
            // Check if the file exists on the server.
            if (file_exists(public_path($selected_building_style_post->building_image_path))) {
                // Delete the selected image.
                unlink(public_path($selected_building_style_post->building_image_path));
            }
        }
        // Delete the selected model instance.
        $selected_building_style_post->delete();
        // Return a redirect to index route.
        return redirect()
            ->route('building-style-post-settings.index')
            ->with('success', 'You have successfully deleted the selected building style post.');
    }
}
