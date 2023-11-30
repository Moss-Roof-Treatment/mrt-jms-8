<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SwmsQuestion;
use App\Models\SwmsQuestionCategory;

class SwmsQuestionController extends Controller
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
        $all_swms_questions = SwmsQuestion::with('swms_question_category')
            ->get();
        // Return the index view.
        return view('menu.settings.swmsQuestions.index')
            ->with('all_swms_questions', $all_swms_questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set The Required Variables.
        $all_swms_question_categories = SwmsQuestionCategory::all('id', 'title');
        // Return the create view.
        return view('menu.settings.swmsQuestions.create')
            ->with('all_swms_question_categories', $all_swms_question_categories);
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
            'swms_question_category_id' => 'required',
            'question' => 'required|string|min:10|max:200',
        ]);
        // Create the new model instance.
        SwmsQuestion::create([
            'swms_question_category_id' => $request->swms_question_category_id,
            'question' => $request->question
        ]);
        // Return the index view.
        return redirect()
            ->route('swms-questions-settings.index')
            ->with('success', 'You have successfully created a new SWMS question.');
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
        $selected_swms_question = SwmsQuestion::findOrFail($id);
        // Set The Required Variables.
        $all_swms_question_categories = SwmsQuestionCategory::all('id', 'title');
        // Return the edit view.
        return view('menu.settings.swmsQuestions.edit')
            ->with([
                'selected_swms_question' => $selected_swms_question,
                'all_swms_question_categories' => $all_swms_question_categories
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
            'swms_question_category_id' => 'required',
            'question' => 'required|string|min:10|max:200',
        ]);
        // Find the required model instance.
        $selected_swms_question = SwmsQuestion::findOrFail($id);
        // Update the selected model instance.
        $selected_swms_question->update([
          'swms_question_category_id' => $request->swms_question_category_id,
          'question' => $request->question
        ]);
        // Return the create view.
        return redirect()
            ->route('swms-questions-settings.index')
            ->with('success', 'You have successfully updated the selected SWMS question.');
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
        $selected_swms = SwmsQuestion::findOrFail($id);
        // Delete the selected model instance.
        $selected_swms->delete();
        // Return the edit view.
        return redirect()
            ->route('swms-questions-settings.index')
            ->with('success', 'You have successfully deleted the selected SWMS question.');
    }
}
