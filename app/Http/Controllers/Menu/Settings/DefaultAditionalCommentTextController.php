<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DefaultAdditionalComment;

class DefaultAditionalCommentTextController extends Controller
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
        $all_default_additional_comment_texts = DefaultAdditionalComment::paginate(20);
        // Return the index view.
        return view('menu.settings.defaultAdditionalComment.index')
            ->with('all_default_additional_comment_texts', $all_default_additional_comment_texts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.defaultAdditionalComment.create');
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
            'text' => 'required|string|min:10|max:750|unique:default_additional_comments,text',
        ]);
        // Create the new model instance.
        DefaultAdditionalComment::create([
            'text' => ucfirst($request->text)
        ]);
        // Return redirect to index route.
        return redirect()
            ->route('default-additional-text-settings.index')
            ->with('success', 'You have successfully created a new default additional comment.');
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
        $selected_default_additional_comment_text = DefaultAdditionalComment::findOrFail($id);
        // Return the show view.
        return view('menu.settings.defaultAdditionalComment.show')
            ->with('selected_default_additional_comment_text', $selected_default_additional_comment_text);
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
        $selected_default_additional_comment_text = DefaultAdditionalComment::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.defaultAdditionalComment.edit')
            ->with('selected_default_additional_comment_text', $selected_default_additional_comment_text);
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
            'text' => 'required|string|min:10|max:750|unique:default_additional_comments,text,'.$id,
        ]);
        // Find the required model instance.
        $selected_default_additional_comment_text = DefaultAdditionalComment::findOrFail($id);
        // Update the selected model instance.
        $selected_default_additional_comment_text->update([
            'text' => ucfirst($request->text)
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('default-additional-text-settings.show', $selected_default_additional_comment_text->id)
            ->with('success', 'You have successfully updated the selected default additional comment.');
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
        $selected_default_additional_comment_text = DefaultAdditionalComment::findOrFail($id);
        // Delete the selected model instance.
        $selected_default_additional_comment_text->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('default-additional-text-settings.index')
            ->with('success', 'You have successfully deleted the selected default additional comment.');
    }
}
