<?php

namespace App\Http\Controllers\Menu\Tradesperson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class QualificationController extends Controller
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
        // Validation.
        // Check if the variable has been supplied.
        if (!isset($_GET['selected_user_id'])) {
            // The variable was not set.
            // Return a redirect back.
            return back()
                ->with('warning', 'The required resource could not be found.');
        }
        // Set The Required Variables.
        // Find the required user.
        $selected_user = User::find($_GET['selected_user_id']);
        // Get all user qualifications.
        $selected_qualifications = Qualification::where('staff_id', $selected_user->id)
            ->get();
        // Return the index view.
        return view('menu.tradespersons.qualifications.index', [
                'selected_user' => $selected_user,
                'selected_qualifications' => $selected_qualifications
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Validation.
        // Check if the variable has been supplied.
        if (!isset($_GET['selected_user_id'])) {
            // The variable was not set.
            // Return a redirect back.
            return back()
                ->with('warning', 'The required resource could not be found.');
        }
        // Set The Required Variables.
        // Find the required user.
        $selected_user = User::find($_GET['selected_user_id']);
        // Return the create view.
        return view('menu.tradespersons.qualifications.create')
            ->with('selected_user', $selected_user);
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
            'title' => 'required',
            'issue_date' => 'sometimes|nullable|date',
            'expiry_date' => 'sometimes|nullable|date',
            'image_path' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Set The Required Variables.
        $selected_user = User::find($request->staff_id);
        // Create the new model instance.
        $new_qualification = Qualification::create([
            'staff_id' => $selected_user->id,
            'title' => $request->title,
            'description' => $request->description,
            'issue_date' => isset($request->issue_date) ? Carbon::parse($request->issue_date)->startOfDay() : null,
            'expiry_date' => isset($request->expiry_date) ? Carbon::parse($request->expiry_date)->startOfDay() : null
        ]);
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::slug($selected_user->getFullNameAttribute() . '-' . $request->title) . '-' . time() . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/qualifications/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->toJpeg(80)->save($location);
            // Update the selected model instance.
            $new_qualification->update([
                'image_path' => 'storage/images/qualifications/' . $filename
            ]);
        }
        // Return a redirect to the index route.
        return redirect()
            ->route('tradesperson-qualifications.show', $new_qualification->id)
            ->with('success', 'You have successfully created a new qualification.');
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
        $selected_qualification = Qualification::findOrFail($id);
        // Return the show view.
        return view('menu.tradespersons.qualifications.show')
            ->with('selected_qualification', $selected_qualification);
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
        $selected_qualification = Qualification::findOrFail($id);
        // Return the show view.
        return view('menu.tradespersons.qualifications.edit')
            ->with('selected_qualification', $selected_qualification);
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
            'title' => 'required|string|min:5|max:100',
            'issue_date' => 'sometimes|nullable|date',
            'expiry_date' => 'sometimes|nullable|date',
            'image' => 'sometimes|nullable|image|mimes:jpeg,jpg,png|max:2048', // 2MB
        ]);
        // Find the required model instance.
        $selected_qualification = Qualification::findOrFail($id);
        // Update the selected model instance.
        $selected_qualification->update([
            'title' => $request->title,
            'description' => $request->description,
            'issue_date' => $request->issue_date == null ? null : Carbon::parse($request->issue_date)->startOfDay(),
            'expiry_date' => $request->expiry_date == null ? null : Carbon::parse($request->expiry_date)->startOfDay()
        ]);
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_qualification->image_path != null && file_exists(public_path($selected_qualification->image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_qualification->image_path));
            }
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::slug($selected_qualification->staff->getFullNameAttribute() . '-' . $request->title) . '.' . $image->getClientOriginalExtension();
            // Set the new file location.
            $location = storage_path('app/public/images/qualifications/' . $filename);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->toJpeg(80)->save($location);
            // Update the selected model instance.
            $selected_qualification->update([
                'image_path' => 'storage/images/qualifications/' . $filename
            ]);
        }
        // Return a redirect to the show route.
        return redirect()
            ->route('tradesperson-qualifications.show', $selected_qualification->id)
            ->with('success', 'You have successfully updated the selected qualification.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Set The Required Variables.
        // Find the required model instance.
        $selected_qualification = Qualification::findOrFail($id);
        // Delete the images relationship instances.
        if ($selected_qualification->image_path != null) {
            if (file_exists(public_path($selected_qualification->image_path))) {
                unlink(public_path($selected_qualification->image_path));
            }
        }
        // Delete the selected model instance.
        $selected_qualification->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('tradesperson-qualifications.index', ['selected_user_id' => $request->selected_user_id])
            ->with('success', 'You have successfully deleted the selected qualification.');
    }
}
