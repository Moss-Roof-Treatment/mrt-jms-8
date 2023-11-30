<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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

        // Create the new model instance.
        $new_testimonial = new Testimonial;
        $new_testimonial->user_id = $request->staff_id;
        $new_testimonial->name = $request->name;
        $new_testimonial->text = $request->text;

        // Create the new image.
        $image = $request->file('image');
        $filename = Str::slug($new_testimonial->id . '-' . $new_testimonial->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
        $new_testimonial->image_path = 'storage/images/testimonials/' . $filename;      
        $location = public_path($new_testimonial->image_path);
        Image::make($image)->orientate()->resize(1280, 720)->save($location);

        $new_testimonial->save();

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
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);

        // Find the required model instance.
        $selected_testimonial = Testimonial::findOrFail($id);

        // Update the selected model instance.
        $selected_testimonial->user_id = $request->staff_id;
        $selected_testimonial->name = $request->name;
        $selected_testimonial->text = $request->text;
        $selected_testimonial->is_visible = $request->is_visible;

        if ($request->hasFile('image')){
            if ($selected_testimonial->image_path != null) {
                if (file_exists(public_path($selected_testimonial->image_path))) {
                    unlink(public_path($selected_testimonial->image_path));
                }
            }
            $image = $request->file('image');
            $filename = Str::slug($selected_testimonial->id . '-' . $selected_testimonial->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $selected_testimonial->image_path = 'storage/images/testimonials/' . $filename;      
            $location = public_path($selected_testimonial->image_path);
            Image::make($image)->orientate()->resize(1280, 720)->save($location);
        }

        $selected_testimonial->save();

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
