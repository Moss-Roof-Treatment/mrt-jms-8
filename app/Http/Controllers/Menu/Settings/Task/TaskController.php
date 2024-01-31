<?php

namespace App\Http\Controllers\Menu\Settings\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuildingStyle;
use App\Models\BuildingType;
use App\Models\Dimension;
use App\Models\MaterialType;
use App\Models\Task;
use App\Models\TaskType;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TaskController extends Controller
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
        // Return the index view.
        return view('menu.settings.tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        // All building styles.
        $all_building_styles = BuildingStyle::all();
        // All building types.
        $all_building_types = BuildingType::all();
        // All dimensions.
        $all_dimensions = Dimension::all();
        // All material types.
        $all_material_types = MaterialType::all();
        // All task types.
        $all_task_types = TaskType::all();
        // Return the create view.
        return view('menu.settings.tasks.create')
            ->with([
                'all_building_styles' => $all_building_styles,
                'all_building_types' => $all_building_types,
                'all_dimensions' => $all_dimensions,
                'all_material_types' => $all_material_types,
                'all_task_types' => $all_task_types
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
        // Check if the selected task type equals 1. - Areas to be treated.
        if ($request->task_type_id == 1) {
            // The selected task type is 1. - Areas to be treated.
            $request->validate([
                'title' => 'required|string|min:5|max:100|unique:tasks',
                'building_style_id' => 'required',
                'building_type_id' => 'required',
                'material_type_id' => 'required',
                'task_type_id' => 'required',
                'dimension_id' => 'required',
                'procedure' => 'required|string|min:10|max:600',
                'description' => 'required|string|min:10|max:600',
                'price' => 'required|numeric',
            ]);
        } else {
            // The selected task type is not 1. - additions - other works.
            $request->validate([
                'title' => 'required|string|min:5|max:100|unique:tasks',
                'task_type_id' => 'required',
                'dimension_id' => 'required',
                'procedure' => 'required|string|min:10|max:600',
                'description' => 'required|string|min:10|max:600',
                'price' => 'required|numeric',
            ]);
        }
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new strorage path for the database.
            $image_storage_location = 'storage/documents/quoteDocuments/' . $filename;
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
        $new_task = Task::create([
            'task_type_id' => $request->task_type_id,
            'building_style_id' => $request->building_style_id,
            'building_type_id' => $request->building_type_id,
            'dimension_id' => $request->dimension_id,
            'material_type_id' => $request->material_type_id,
            'title' => $request->title,
            'procedure' => $request->procedure,
            'description' => $request->description,
            'price' => intval(preg_replace('/[$.,]/', '', $request->price)), // Strip all dollar signs, commas and periods, then set to integer.
            'image_path' => $image_storage_location ?? null,
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('task-settings.show', $new_task->id)
            ->with('success', 'You have successfully created a new task.');
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
        $selected_task = Task::findOrFail($id);
        // Return the show view.
        return view('menu.settings.tasks.show')
            ->with('selected_task', $selected_task);
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
        $selected_task = Task::findOrFail($id);
        // Set The Required Variables.
        // All building styles.
        $all_building_styles = BuildingStyle::all();
        // All building types.
        $all_building_types = BuildingType::all();
        // All dimensions.
        $all_dimensions = Dimension::all();
        // All material types.
        $all_material_types = MaterialType::all();
        // All task types.
        $all_task_types = TaskType::all();
        // Return the edit view.
        return view('menu.settings.tasks.edit')
            ->with([
                'all_building_styles' => $all_building_styles,
                'all_building_types' => $all_building_types,
                'all_dimensions' => $all_dimensions,
                'all_material_types' => $all_material_types,
                'all_task_types' => $all_task_types,
                'selected_task' => $selected_task
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
        // Check if the selected task type equals 1. - Areas to be treated.
        if ($request->task_type_id == 1) {
            // The selected task type is 1. - Areas to be treated.
            $request->validate([
                'title' => 'required|string|min:5|max:100|unique:tasks,title,'. $id,
                'building_style_id' => 'required',
                'building_type_id' => 'required',
                'material_type_id' => 'required',
                'task_type_id' => 'required',
                'dimension_id' => 'required',
                'procedure' => 'required|string|min:10|max:600',
                'description' => 'required|string|min:10|max:600',
                'price' => 'required|numeric',
            ]);
        } else {
            // The selected task type is not 1. - additions - other works.
            $request->validate([
                'title' => 'required|string|min:5|max:100|unique:tasks,title,'. $id,
                'task_type_id' => 'required',
                'dimension_id' => 'required',
                'procedure' => 'required|string|min:10|max:600',
                'description' => 'required|string|min:10|max:600',
                'price' => 'required|numeric',
            ]);
        }
        // Find the selected model instance.
        $selected_task = Task::findOrFail($id);
        // Check the request data for the required file.
        if ($request->hasFile('image')) {
            // Check if the file path value is not null and file exists on the server.
            if ($selected_task->image_path != null && file_exists(public_path($selected_task->image_path))) {
                // Delete the file from the server.
                unlink(public_path($selected_task->image_path));
            }
            // Set the uploaded file.
            $image = $request->file('image');
            // Set the new file name.
            $filename = Str::orderedUuid() . '.' . $image->getClientOriginalExtension();
            // Set the new strorage path for the database.
            $image_storage_location = 'storage/images/tasks/' . $filename;
            // Set the new file location.
            $location = public_path($image_storage_location);
            // Create new manager instance with desired driver.
            $manager = new ImageManager(new Driver());
            // Read image from filesystem
            $image = $manager->read($image);
            // Encoding jpeg data
            $image->toJpeg(80)->save($location);
        }
        // Update the selected model instance.
        $selected_task->update([
            'task_type_id' => $request->task_type_id,
            'building_style_id' => $request->building_style_id,
            'building_type_id' => $request->building_type_id,
            'dimension_id' => $request->dimension_id,
            'material_type_id' => $request->material_type_id,
            'title' => $request->title,
            'procedure' => $request->procedure, 
            'description' => $request->description, 
            'price' => intval(preg_replace('/[$.,]/', '', $request->price)), // Strip all dollar signs, commas and periods, then set to integer.
            'is_quote_visible' => $request->is_quote_visible,
            'is_selectable' => $request->is_selectable,
            'uses_product' => $request->uses_product,
            'image_path' => $image_storage_location ?? $selected_task->image_path,
        ]);
        // Return redirect to the show page.
        return redirect()
            ->route('task-settings.show', $selected_task->id)
            ->with('success', 'You have successfully edited the selected task.');
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
        $selected_task = Task::findOrFail($id);
        // Check if the file path value is not null and file exists on the server.
        if ($selected_task->image_path != null && file_exists(public_path($selected_task->image_path))) {
            // Delete the file from the server.
            unlink(public_path($selected_task->image_path));
        }
        // Delete the selected model instance.
        $selected_task->delete();
        // Return redirect to the index page.
        return redirect()
            ->route('task-settings.index')
            ->with('success', 'You have successfully deleted the selected task.');
    }
}
