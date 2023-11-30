<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DefaultPropertiesToView;

class DefaultPropertiesToViewController extends Controller
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
        $all_default_properties_to_view = DefaultPropertiesToView::all();
        // Return the index view.
        return view('menu.settings.defaultPropertiesToView.index')
            ->with('all_default_properties_to_view', $all_default_properties_to_view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.defaultPropertiesToView.create');
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
            'title' => 'required|string|min:10|max:150',
            'property_1' => 'required|string|min:15|max:150',
            'property_2' => 'sometimes|nullable|string|min:15|max:150',
            'property_3' => 'sometimes|nullable|string|min:15|max:150',
            'property_4' => 'sometimes|nullable|string|min:15|max:150'
        ]);
        // Create the new model instance.
        $new_default_properties_to_view = DefaultPropertiesToView::create([
            'title' => ucfirst($request->title),
            'property_1' => ucwords($request->property_1),
            'property_2' => ucwords($request->property_2),
            'property_3' => ucwords($request->property_3),
            'property_4' => ucwords($request->property_4)
        ]);
        // Return redirect to index route.
        return redirect()
            ->route('default-properties-settings.show', $new_default_properties_to_view->id)
            ->with('success', 'You have successfully created a new default properties to view.');
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
        $selected_default_properties_to_view = DefaultPropertiesToView::findOrFail($id);
        // Return the show view.
        return view('menu.settings.defaultPropertiesToView.show')
            ->with('selected_default_properties_to_view', $selected_default_properties_to_view);
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
        $selected_default_properties_to_view = DefaultPropertiesToView::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.defaultPropertiesToView.edit')
            ->with('selected_default_properties_to_view', $selected_default_properties_to_view);
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
            'title' => 'required|string|min:10|max:150',
            'property_1' => 'required|string|min:15|max:150',
            'property_2' => 'sometimes|nullable|string|min:15|max:150',
            'property_3' => 'sometimes|nullable|string|min:15|max:150',
            'property_4' => 'sometimes|nullable|string|min:15|max:150'
        ]);
        // Find the required model instance.
        $selected_default_properties_to_view = DefaultPropertiesToView::findOrFail($id);
        // Update the selected model instance.
        $selected_default_properties_to_view->update([
            'title' => ucfirst($request->title),
            'property_1' => ucwords($request->property_1),
            'property_2' => ucwords($request->property_2),
            'property_3' => ucwords($request->property_3),
            'property_4' => ucwords($request->property_4)
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('default-properties-settings.show', $selected_default_properties_to_view->id)
            ->with('success', 'You have successfully updated the selected default image text.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if there are any jobs that have the selected id.
        $selected_quotes = Job::where('default_properties_to_view_id', $id);
        // Find the required model instance.
        $selected_default_properties_to_view = DefaultImageTitle::findOrFail($id);
        // Secondary Validation.
        // Check the count of the selected quote variable.
        if ($selected_quotes != null) {
            // update the selected default image title
            $selected_default_properties_to_view->update([
                'is_delible' => 0
            ]);
            // Return a redirect back.
            return back()
                ->with('warning', 'You cannot delete this item as it is used within the system.');
        }
        // Delete the selected model instance.
        $selected_default_properties_to_view->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('default-image-title-settings.index')
            ->with('success', 'You have successfully deleted the selected default image title.');
    }
}
