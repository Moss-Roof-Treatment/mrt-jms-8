<?php

namespace App\Http\Controllers\Menu\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\SurveyAnswer;

class SurveyIndividualController extends Controller
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
        // Find the required model instance.
        $all_surveys = Survey::has('quote')
            ->with('user')
            ->with('quote')
            ->with('quote.job')
            ->orderBy('quote_id')
            ->get();
        // Return the index view.
        return view('menu.reports.survey.individual.index')
            ->with('all_surveys', $all_surveys);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Validate the request data
        $request->validate([
            'job' => 'required|integer',
        ]);
        // Set The Required Variables.
        // Find The survey that has the selected job id.
        $selected_survey = Survey::where('id', $request->job)
            ->with('quote')
            ->with('quote.job')
            ->with('survey_testimonial')
            ->first();
        // Find the survey answers that have the selected survey id. 
        $survey_answers = SurveyAnswer::where('survey_id', $selected_survey->id)->get();
        // Find all survey responses that have a job.
        $all_surveys = Survey::has('quote')
            ->with('user')
            ->with('quote')
            ->with('quote.job')
            ->orderBy('quote_id')
            ->get();
        // Return the show view.
        return view('menu.reports.survey.individual.show')
            ->with([
                'all_surveys' => $all_surveys,
                'survey_answers' => $survey_answers,
                'selected_survey' => $selected_survey
            ]);
    }
}
