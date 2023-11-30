<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Swms;
use App\Models\SwmsQuestion;
use App\Models\SwmsQuestionCategory;
use PDF;

class SwmsController extends Controller
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
        // Set the session data.
        // Pull old session variable.
        if (session()->has('selected_swms_id')) {
            session()->pull('selected_swms_id');
        }
        // Find all of the required model instances.
        $all_swms = Swms::with('quote')
            ->with('tradesperson')
            ->get();
        // Return the index view.
        return view('menu.settings.swms.index')
            ->with('all_swms', $all_swms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Find the required model instance.
        // ???????????? this has been changed to find of fail due to error in the logs. session will be removed soon.
        $selected_swms = Swms::findOrFail(session('selected_swms_id'));

        // All SWMS Question Categories.
        $all_swms_question_categories = SwmsQuestionCategory::all();

        // Set The Required Variables.
        // Set the answers array.
        if ($selected_swms->answers_array == null) {
            // The answers array is null.
            $answers_array = [];
        } else {
            // The answers array is not null.
            $answers_array = unserialize($selected_swms->answers_array);
        }

        // Create the footer object.
        $footer = '<!DOCTYPE html> <img class="img-responsive" style="width:100%;" src="' . public_path('storage/images/letterheads/mrt-letter-footer.jpg') . '">';

        // Generate PDF.
        $pdf = PDF::loadView('profile.jobs.swms.create', compact('selected_swms', 'answers_array', 'all_swms_question_categories'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('orientation', 'portrait')
            ->setOption('footer-html', $footer);

        // Set pdf title
        $pdf_title = $selected_swms->quote->quote_identifier . '-swms.pdf';

        // Download as pdf.
        return $pdf->download($pdf_title);
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
        $selected_swms = Swms::findOrFail($id);

        // Set the session data.
        // Pull old session variable.
        if (session()->has('selected_swms_id')) {
            session()->pull('selected_swms_id');
        }

        // Set new session variable.
        session([
            'selected_swms_id' => $selected_swms->id
        ]);

        // Set The Required Variables.
        // All SWMS Questions.
        $all_swms_questions = SwmsQuestion::all();

        // All SWMS Question Categories.
        $all_swms_question_categories = SwmsQuestionCategory::all();

        // Set the answers array.
        if ($selected_swms->answers_array == null) {
            // The answers array is null.
            $answers_array = [];
        } else {
            // The answers array is not null.
            $answers_array = unserialize($selected_swms->answers_array);
        }

        // Return the show view.
        return view('menu.settings.swms.show')
            ->with([
                'all_swms_questions' => $all_swms_questions,
                'all_swms_question_categories' => $all_swms_question_categories,
                'answers_array' => $answers_array,
                'selected_swms' => $selected_swms
            ]);
    }
}
