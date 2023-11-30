<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SwmsQuestionCategory;

class SwmsQuestionCategoryController extends Controller
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
        $all_swms_question_categories = SwmsQuestionCategory::all();
        // Return the index view.
        return view('menu.settings.swmsQuestionCategories.index')
            ->with('all_swms_question_categories', $all_swms_question_categories);
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
        $selected_swms_question_category = SwmsQuestionCategory::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.swmsQuestionCategories.edit')
            ->with('selected_swms_question_category', $selected_swms_question_category);
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
            'title' => 'required|string|min:10|max:200',
            'description' => 'required|string|min:10|max:200',
        ]);
        // Find the required model instance.
        $selected_swms_question_category = SwmsQuestionCategory::findOrFail($id);
        // Update the selected model instance.
        $selected_swms_question_category->update([
            'title' => ucwords($request->title),
            'description' => ucwords($request->description)
        ]);
        // Return the create view.
        return redirect()
            ->route('swms-questions-category-settings.index')
            ->with('success', 'You have successfully updated the selected SWMS question category.');
    }
}