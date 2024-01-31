<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TaskTypeController extends Controller
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
        $all_task_types = TaskType::paginate(20);
        // Return the index view.
        return view('menu.settings.taskTypes.index')
            ->with('all_task_types', $all_task_types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.taskTypes.create');
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
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new strorage path for the database.
            $image_storage_location = 'storage/images/taskTypes/' . $filename;
            // Set the new file location.
            $location = public_path($image_storage_location);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
        }
        // Create the new model instance.
        $new_task_type = TaskType::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $image_storage_location ?? null,
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('task-type-settings.show', $new_task_type->id)
            ->with('success', 'You have successfully created a new task type.');
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
        $selected_task_type = TaskType::findOrFail($id);
        // Set The Required Variables.
        $all_tasks = Task::where('task_type_id', $id)
            ->get();
        // Return the index view.
        return view('menu.settings.taskTypes.show')
            ->with([
                'selected_task_type' => $selected_task_type,
                'all_tasks' => $all_tasks
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
        $selected_task_type = TaskType::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.taskTypes.edit')
            ->with('selected_task_type', $selected_task_type);
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
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        // Find the required model instance.
        $selected_task_type = TaskType::findOrFail($id);
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_task_type->image_path != null && file_exists(public_path($selected_task_type->image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_task_type->image_path));
            }
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new strorage path for the database.
            $image_storage_location = 'storage/images/taskTypes/' . $filename;
            // Set the new file location.
            $location = public_path($image_storage_location);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->resize(256, 256)->toJpeg(80)->save($location);
        }
        // Update the selected model instance.
        $selected_task_type->update([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $image_storage_location ?? $selected_task_type->image_path,
        ]);
        // Return the edit view.
        return redirect()
            ->route('task-type-settings.show', $selected_task_type->id)
            ->with('success', 'You have successfully edited the selected task type.');
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
        $selected_task_type = TaskType::findOrFail($id);
        // Check if the file path value is not null and file exists on the server.
        if ($selected_task_type->image_path != null && file_exists(public_path($selected_task_type->image_path))) {
            // Delete the file from the server.
            unlink(public_path($selected_task_type->image_path));
        }
        // Delete the selected model instance.
        $selected_task_type->tasks()->delete();
        $selected_task_type->delete();
        // Return a redirect to the index view.
        return redirect()
            ->route('task-type-settings.index')
            ->with('success', 'You have successfully deleted the selected task type.');
    }
}
