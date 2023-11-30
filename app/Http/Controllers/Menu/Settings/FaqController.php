<?php

namespace App\Http\Controllers\Menu\Settings;

use App\Http\Controllers\Controller;
use App\Models\FrequentlyAskedQuestion;
use Illuminate\Http\Request;

class FaqController extends Controller
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
        $all_faqs = FrequentlyAskedQuestion::all('id', 'question');
        // Return the index view.
        return view('menu.settings.faq.index')
            ->with('all_faqs', $all_faqs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.settings.faq.create');
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
            'question' => 'required|min:10|max:500|unique:frequently_asked_questions,question',
            'answer' => 'required|min:10|max:500',
        ]);
        // Create the new model instance.
        FrequentlyAskedQuestion::create([
            'question' => ucfirst($request->question),
            'answer' => ucfirst($request->answer),
            'is_visible' => $request->is_visible,
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('faq-settings.index')
            ->with('success', 'You have successfully created a new frequently asked question.');
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
        // Find the required model instance.
        $selected_faq = FrequentlyAskedQuestion::findOrFail($id);
        // Return the show view.
        return view('menu.settings.faq.show', [
            'selected_faq' => $selected_faq
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Set The Required Variables.
        // Find the required model instance.
        $selected_faq = FrequentlyAskedQuestion::findOrFail($id);
        // Return the edit view.
        return view('menu.settings.faq.edit', [
            'selected_faq' => $selected_faq
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
            'question' => 'required|min:10|max:500|unique:frequently_asked_questions,question,'.$id,
            'answer' => 'required|min:10|max:500',
        ]);
        // Find the required model instance.
        $selected_faq = FrequentlyAskedQuestion::findOrFail($id);
        // Update the selected model instance.
        $selected_faq->update([
            'question' => ucfirst($request->question),
            'answer' => ucfirst($request->answer),
            'is_visible' => $request->is_visible,
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('faq-settings.index')
            ->with('success', 'You have successfully updated the selected frequently asked question.');
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
        $selected_faq = FrequentlyAskedQuestion::findOrFail($id);
        // Delete the selected model instance.
        $selected_faq->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('faq-settings.index')
            ->with('success', 'You have successfully updated the selected job progress.');
    }
}
