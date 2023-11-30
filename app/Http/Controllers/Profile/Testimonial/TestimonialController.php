<?php

namespace App\Http\Controllers\Profile\Testimonial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteUser;
use App\Models\Survey;
use App\Models\SurveyTestimonial;
use App\Models\Testimonial;
use Auth;

class TestimonialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAnyStaffMember');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // All Quote Tradespersons of the selected tradesperson.
        $all_quotes = QuoteUser::where('tradesperson_id', Auth::id())
            ->pluck('quote_id');
        // Find all surveys related to the selected tradesperson.
        $all_surveys = Survey::whereIn('quote_id', $all_quotes)
            ->pluck('id')->toArray();
        // Find all survey testimonials.
        $selected_survey_testimonials = SurveyTestimonial::where('is_visible', 1) // Is publically visible.
            ->whereIn('survey_id', $all_surveys)
            ->with('survey')
            ->with('survey.quote')
            ->with('survey.user')
            ->get();
        $selected_testimonials = Testimonial::where('user_id', Auth::id())
            ->get();
        // Return the index view
        return view('profile.testimonials.index')
            ->with([
                'selected_survey_testimonials' => $selected_survey_testimonials,
                'selected_testimonials' => $selected_testimonials
            ]);
    }
}
