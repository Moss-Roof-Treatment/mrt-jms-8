<?php

namespace App\Http\Controllers\Profile\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Swms;
use App\Models\SwmsQuestion;
use App\Models\SwmsQuestionCategory;
use Auth;
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
        $this->middleware('isAnyStaffMember');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Find the required model instance.
        $selected_swms = Swms::findOrFail($_GET['selected_swms_id']);
        // Set The Required Variables.
        // Authenticated user.
        $selected_tradesperson_id = Auth::id();
        // All SWMS Question Categories.
        $all_swms_question_categories = SwmsQuestionCategory::all();
        // Set the answers array.
        $answers_array = $selected_swms->answers_array != null ? unserialize($selected_swms->answers_array) : [];
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
        // Set The Required Variables.
        // Authenticated user.
        $selected_tradesperson_id = Auth::id();
        // All SWMS Questions.
        $all_swms_questions = SwmsQuestion::all();
        // All SWMS Question Categories.
        $all_swms_question_categories = SwmsQuestionCategory::all();
        // Find the required model instance.
        $selected_swms = Swms::where('quote_id', $id)
            ->where('tradesperson_id', $selected_tradesperson_id)
            ->first();
        // Create the new model instance if required.
        // Check if a swms model instance already exists.
        if ($selected_swms == null) {
          // there is no swms model instance, so create one.
          $selected_swms = Swms::create([
              'quote_id' => $id,
              'tradesperson_id' => $selected_tradesperson_id
          ]);
        }
        // Set the answers array.
        $answers_array = $selected_swms->answers_array == null ? [] : unserialize($selected_swms->answers_array);
        // Return the show view.
        return view('profile.jobs.swms.show')
            ->with([
                'all_swms_questions' => $all_swms_questions,
                'all_swms_question_categories' => $all_swms_question_categories,
                'answers_array' => $answers_array,
                'selected_swms' => $selected_swms
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
        // Find the required model instance.
        $selected_swms = Swms::findOrFail($id);
        // Update the selected model instance.
        $selected_swms->update([
            'answers_array' => $request->questions == null ? null : serialize($request->questions)
        ]);
        // Return redirect back.
        return back()
            ->with('success', 'You have successfully updated the selected SWMS.');
    }
}
