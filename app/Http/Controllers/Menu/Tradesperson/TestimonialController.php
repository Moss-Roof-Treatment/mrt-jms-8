<?php

namespace App\Http\Controllers\Menu\Tradesperson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteUser;
use App\Models\Survey;
use App\Models\SurveyTestimonial;
use App\Models\Testimonial;
use App\Models\User;

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
        $this->middleware('isStaff');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Validation.
        // Check if the variable has been supplied.
        if (!isset($_GET['selected_user_id'])) {
            // The variable was not set.
            // Return a redirect back.
            return back()
                ->with('warning', 'The required resource could not be found.');
        }
        // Set The Required Variables.
        // Find the required user.
        $selected_user = User::find($_GET['selected_user_id']);
        // All Quote Tradespersons of the selected tradesperson.
        $all_quotes = QuoteUser::where('tradesperson_id', $selected_user->id)
            ->pluck('quote_id');
        // Find all surveys related to the selected tradesperson.
        $all_surveys = Survey::whereIn('quote_id', $all_quotes)
            ->pluck('id')->toArray();
        // Find all survey testimonials.
        $selected_survey_testimonials = SurveyTestimonial::where('is_visible', 1) // Is publically visible.
            ->whereIn('survey_id', $all_surveys)
            ->with('survey')
            ->with('survey.user')
            ->get();
        // Find all manual testimonials.
        $selected_testimonials = Testimonial::where('user_id', $selected_user->id)
            ->with('user')
            ->get();
        // Return the index view.
        return view('menu.tradespersons.testimonials.index')
            ->with([
                'selected_user' => $selected_user,
                'selected_survey_testimonials' => $selected_survey_testimonials,
                'selected_testimonials' => $selected_testimonials
            ]);
    }
}
