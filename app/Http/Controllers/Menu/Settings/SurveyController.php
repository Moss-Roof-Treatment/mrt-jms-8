<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\SurveyTestimonial;

class SurveyController extends Controller
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
        $all_surveys = Survey::with('survey_testimonial')
            ->with('quote.job')
            ->with('quote.customer')
            ->paginate(20);
        // Return the index view.
        return view('menu.settings.surveys.index')
            ->with('all_surveys', $all_surveys);
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
        $selected_survey = Survey::findOrFail($id);
        // Return the show view.
        return view('menu.settings.surveys.show')
            ->with('selected_survey', $selected_survey);
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
        $selected_survey = Survey::findOrFail($id);
        // Return the show view.
        return view('menu.settings.surveys.edit')
            ->with('selected_survey', $selected_survey);
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
        $selected_survey = Survey::findOrFail($id);
        // Set The Required Variables.
        $selected_testimonial = SurveyTestimonial::where('survey_id', $id)
            ->first();
        // Update the selected model instance.
        $selected_testimonial->update([
            'text' => $request->text,
            'is_visible' => $request->is_visible
        ]);
        // Update the selected model instance.
        return redirect()
            ->route('survey-settings.show', $id)
            ->with('success', 'You have successfully updated the selected survey.');
    }
}
