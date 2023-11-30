<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DefaultImageTitle;

class DefaultImageTitleController extends Controller
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
        $all_default_image_titles = DefaultImageTitle::paginate(20);
        // Return the index view.
        return view('menu.settings.defaultImageTitles.index')
            ->with('all_default_image_titles', $all_default_image_titles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.defaultImageTitles.create');
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
            'text' => 'required|string|min:10|max:255|unique:default_image_titles,text',
        ]);
        // Create the new model instance.
        DefaultImageTitle::create([
            'text' => ucfirst($request->text)
        ]);
        // Return redirect to index route.
        return redirect()
            ->route('default-image-title-settings.index')
            ->with('success', 'You have successfully created a new default image title.');
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
        $selected_default_image_title = DefaultImageTitle::findOrFail($id);
        // Return the show view.
        return view('menu.settings.defaultImageTitles.show')
            ->with('selected_default_image_title', $selected_default_image_title);
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
        $selected_default_image_title = DefaultImageTitle::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.defaultImageTitles.edit')
            ->with('selected_default_image_title', $selected_default_image_title);
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
            'text' => 'required|string|min:10|max:255|unique:default_image_titles,text,'.$id,
        ]);
        // Find the required model instance.
        $selected_default_image_title = DefaultImageTitle::findOrFail($id);
        // Update the selected model instance.
        $selected_default_image_title->update([
            'text' => ucfirst($request->text)
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('default-image-title-settings.show', $selected_default_image_title->id)
            ->with('success', 'You have successfully updated the selected default image title.');
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
        $selected_default_image_title = DefaultImageTitle::findOrFail($id);
        // Delete the selected model instance.
        $selected_default_image_title->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('default-image-title-settings.index')
            ->with('success', 'You have successfully deleted the selected default image title.');
    }
}
