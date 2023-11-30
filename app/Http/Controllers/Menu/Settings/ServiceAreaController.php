<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceArea;
use Illuminate\Support\Str;

class ServiceAreaController extends Controller
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
        $all_service_areas = ServiceArea::all();
        // Return the index view.
        return view('menu.settings.serviceAreas.index')
            ->with('all_service_areas', $all_service_areas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.serviceAreas.create');
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
            'title' => 'required|string|min:3|max:50|unique:service_areas',
            'subtitle' => 'sometimes|nullable|string|min:3|max:150',
            'text' => 'required|string|min:3|max:1000',
            'video_link' => 'required|string|min:20|max:200',
            'video_text' => 'required|string|min:3|max:1000',
            'second_subtitle' => 'required|string|min:10|max:200',
            'second_text' => 'required|string|min:3|max:1000',
        ]);

        // Create a new model instance.
        $new_service_area = ServiceArea::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'subtitle' => $request->subtitle,
            'text' => $request->text,
            'video_link' => $request->video_link,
            'video_text' => $request->video_text,
            'second_subtitle' => $request->second_subtitle,
            'second_text' => $request->second_text,
        ]);

        // Return a redirect to the show route.
        return redirect()
            ->route('service-area-settings.show', $new_service_area->id)
            ->with('success', 'You have successfully created a new service area.');
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
        $selected_service_area = ServiceArea::findOrFail($id);
        // Return the show view.
        return view('menu.settings.serviceAreas.show')
            ->with('selected_service_area', $selected_service_area);
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
        $selected_service_area = ServiceArea::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.serviceAreas.edit')
            ->with('selected_service_area', $selected_service_area);
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
            'title' => 'required|string|min:3|max:50|unique:service_areas,title,'.$id,
            'subtitle' => 'sometimes|nullable|string|min:3|max:150',
            'text' => 'required|string|min:3|max:1000',
            'video_link' => 'required|string|min:20|max:200',
            'video_text' => 'required|string|min:3|max:1000',
            'second_subtitle' => 'required|string|min:10|max:200',
            'second_text' => 'required|string|min:3|max:1000',
        ]);

        // Find the required model instance.
        $selected_service_area = ServiceArea::findOrFail($id);

        // Update the selected model instance.
        $selected_service_area->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'subtitle' => $request->subtitle,
            'text' => $request->text,
            'video_link' => $request->video_link,
            'video_text' => $request->video_text,
            'second_subtitle' => $request->second_subtitle,
            'second_text' => $request->second_text,
            'is_featured' => $request->is_featured,
            'is_visible' => $request->is_visible,
        ]);

        // Return a redirect to the index route.
        return redirect()
            ->route('service-area-settings.show', $id)
            ->with('success', 'You have successfully edited the selected service area.');
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
        $selected_service_area = ServiceArea::findOrFail($id);
        // Delete the selected model instance.
        $selected_service_area->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('service-area-settings.index')
            ->with('success', 'You have successfully deleted the selected service area.');
    }
}
