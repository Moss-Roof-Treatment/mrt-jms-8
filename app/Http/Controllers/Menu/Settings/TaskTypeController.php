<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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

        // Create the new model instance.
        $new_task_type = new TaskType;
        $new_task_type->title = $request->title;
        $new_task_type->description = $request->description;

        // Image Upload.
        $file = $request->file('image');
        $filename = Str::slug($new_task_type->title) . '_task_type' . '.' . $file->getClientOriginalExtension(); 
        $new_task_type->image_path = 'storage/images/taskTypes/' . $filename;
        $location = storage_path('app/public/images/taskTypes/' . $filename);
        Image::make($file)->orientate()->resize(256, 256)->save($location);

        // Save the model instance.
        $new_task_type->save();

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
        // Find the required model instance.
        $selected_task_type = TaskType::findOrFail($id);

        // Find the required model instance.
        $selected_task_type->title = $request->title;
        $selected_task_type->description = $request->description;

        // Image Upload.
        if ($request->hasFile('image')){

            if ($selected_task_type->image_path != null) {

                if (file_exists(public_path($selected_task_type->image_path))) {

                    unlink(public_path($selected_task_type->image_path));
                }
            }

            $file = $request->file('image');
            $filename = Str::slug($selected_task_type->title) . '_task_type' . '.' . $file->getClientOriginalExtension();
            $selected_task_type->image_path = 'storage/images/taskTypes/' . $filename;
            $location = storage_path('app/public/images/taskTypes/' . $filename);
            Image::make($file)->orientate()->resize(256, 256)->save($location);
        }

        // Save the model instance.
        $selected_task_type->save();

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
        // Delete the image if required.
        if ($selected_task_type->image_path != null) {
            if (file_exists(public_path($selected_task_type->image_path))) {
                unlink(public_path($selected_task_type->image_path));
            }
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
