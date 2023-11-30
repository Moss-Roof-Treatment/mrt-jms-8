<?php

namespace App\Http\Controllers\Menu\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\QuoteUser;
use App\Models\User;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyAnswer;

class SurveyOverallController extends Controller
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
        // Set The Required Variables.
        // FIND ALL TRADESPERSONS
        // Find all quotes with a survey.
        $all_quotes_with_survey = Quote::whereHas('survey')->pluck('id');
        // Find quote tradespersons from the selected quotes.
        $selected_quote_tradespersons = QuoteUser::wherein('quote_id', $all_quotes_with_survey)
            ->distinct('tradesperson_id')
            ->pluck('tradesperson_id')
            ->toArray();
        // All tradespersons on quotes with surveys.
        $all_tradespersons = User::find($selected_quote_tradespersons);
        // All survey questions.
        $all_questions = SurveyQuestion::all();
        // Count of all surveys.
        $all_surveys_count = Survey::count();
        // Return the index view.
        return view('menu.reports.survey.overall.index')
            ->with([
                'all_tradespersons' => $all_tradespersons,
                'all_questions' => $all_questions,
                'all_surveys_count' => $all_surveys_count
            ]);
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
            'tradesperson' => 'required|integer',
        ]);
        // Set The Required Variables.
        // FIND ALL TRADESPERSONS
        // Find all quotes with a survey.
        $all_quotes_with_survey = Quote::whereHas('survey')->pluck('id');
        // Find quote tradespersons from the selected quotes.
        $selected_quote_tradespersons = QuoteUser::wherein('quote_id', $all_quotes_with_survey)
            ->distinct('tradesperson_id')
            ->pluck('tradesperson_id')
            ->toArray();
        // All tradespersons on quotes with surveys.
        $all_tradespersons = User::find($selected_quote_tradespersons);
        // Select the tradesperson by prepared id.
        $selected_tradesperson = User::find($request->tradesperson);
        // All Quote Tradespersons of the selected tradesperson.
        $all_quotes = QuoteUser::where('tradesperson_id', $selected_tradesperson->id)
            ->pluck('quote_id')
            ->toArray();
        // Create an empty array.
        $overall_results = [];
        // Find all surveys related to the selected tradesperson.
        $all_surveys = Survey::whereIn('quote_id', $all_quotes)
            ->pluck('id')
            ->toArray();
        // Find all of the answers from the selected tradespersons surveys and group them by the question id.
        $all_answers = SurveyAnswer::whereIn('survey_id', $all_surveys)->get()->groupBy('survey_question_id');
        // Loop through each group of answers.
        foreach($all_answers as $all_answers_groups) {
            // Find the adverage of the answers in the group.
            $summed_answer = $all_answers_groups->average('answer');
            // Trim to 1 decimal place.
            $formatted_summed_answer = number_format($summed_answer, 2);
            // Push the value to the array.
            array_push($overall_results, $formatted_summed_answer);
        }
        // All survey questions.
        $all_survey_questions = SurveyQuestion::all();
        // Return the show view.
        return view('menu.reports.survey.overall.show')
            ->with([
                'selected_tradesperson' => $selected_tradesperson,
                'all_tradespersons' => $all_tradespersons,
                'overall_results' => $overall_results,
                'all_survey_questions' => $all_survey_questions
            ]);
    }
}
