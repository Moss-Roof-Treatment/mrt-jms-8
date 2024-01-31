<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ManualTestimonialController extends Controller
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
        $all_testimonials = Testimonial::paginate(20);
        // Return the index view.
        return view('menu.settings.testimonials.index')
            ->with('all_testimonials', $all_testimonials);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // All staff users.
        $staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('id', '!=', 1) // Not the first user in the database.
            ->where('login_status_id', 1) // 1 = Is Active.
            ->with('account_role')
            ->get();
        // Return the create view.
        return view('menu.settings.testimonials.create')
            ->with('staff_members', $staff_members);
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
            'staff_id' => 'required',
            'name' => 'required|string',
            'text' => 'required|string|min:10|max:500',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new strorage path for the database.
            $storage_location = 'storage/images/testimonials/' . $filename;
            // Set the new file location.
            $location = public_path($storage_location);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(1280, 720)->toJpeg(80)->save($location);
        }
        // Create the new model instance.
        Testimonial::create([
            'user_id' => $request->staff_id,
            'name' => $request->name,
            'text' => $request->text,
            'image_path' => $storage_location ?? null,
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('manual-testimonials-settings.index')
            ->with('success', 'You have successfully created a new manual testimonial.');
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
        $selected_testimonial = Testimonial::findOrFail($id);
        // Return the index view.
        return view('menu.settings.testimonials.show')
            ->with('selected_testimonial', $selected_testimonial);
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
        $selected_testimonial = Testimonial::findOrFail($id);
        // Set The Required Variables.
        // All staff users.
        $staff_members = User::whereIn('account_role_id', [1,2,3,4]) // 1 = Super User, 2 = Staff, 3 = Tradesperson, 4 = Contractor.
            ->where('id', '!=', 1) // Not the first user in the database.
            ->with('account_role')
            ->get();
        // Return the edit view.
        return view('menu.settings.testimonials.edit')
            ->with([
                'selected_testimonial' => $selected_testimonial,
                'staff_members' => $staff_members
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
            'staff_id' => 'required',
            'name' => 'required|string',
            'text' => 'required|string|min:10|max:500',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Find the required model instance.
        $selected_testimonial = Testimonial::findOrFail($id);
        // Check if a new image has been uploaded.
        if ($request->hasFile('image')){
            // Check if the file path value is not null and file exists on the server.
            if ($selected_testimonial->image_path != null && file_exists(public_path($selected_testimonial->image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_testimonial->image_path));
            }
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new strorage path for the database.
            $storage_location = 'storage/images/testimonials/' . $filename;
            // Set the new file location.
            $location = public_path($storage_location);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(1280, 720)->toJpeg(80)->save($location);

        }
        // Update the selected model instance.
        $selected_testimonial->update([
            'user_id' => $request->staff_id,
            'name' => $request->name,
            'text' => $request->text,
            'is_visible' => $request->is_visible,
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('manual-testimonials-settings.show', $selected_testimonial->id)
            ->with('success', 'You have successfully updated the selected manual testimonial.');
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
        $selected_testimonial = Testimonial::findOrFail($id);
        // Delete the selected model instance.
        $selected_testimonial->delete();
        // Return a redirect to index route.
        return redirect()
            ->route('manual-testimonials-settings.index')
            ->with('success', 'You have successfully deleted the selected testimonial.');
    }
}
