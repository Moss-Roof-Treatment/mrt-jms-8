<?php

namespace App\Http\Controllers\Menu\Email\QuoteReminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DefaultEmailResponseText;

class DefaultEmailResponseTextController extends Controller
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
        $all_default_email_response_texts = DefaultEmailResponseText::paginate(20);
        // Return the index view.
        return view('menu.emails.quoteReminders.defaultEmailResponseTexts.index')
            ->with('all_default_email_response_texts', $all_default_email_response_texts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.emails.quoteReminders.defaultEmailResponseTexts.create');
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
            'text' => 'required|string|min:5|max:100',
            'type' => 'sometimes|nullable|numeric'
        ]);
        // Create the new model instance.
        $new_default_email_response_text = DefaultEmailResponseText::create([
            'text' => $request->text,
            'type' => $request->type
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('default-email-response-text.index')
            ->with('success', 'You have successfully created a new default email response text.');
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
        $selected_default_email_response_text = DefaultEmailResponseText::findOrFail($id);
        // Return the edit view.
        return view('menu.emails.quoteReminders.defaultEmailResponseTexts.edit')
            ->with('selected_default_email_response_text', $selected_default_email_response_text);
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
            'text' => 'required|string|min:5|max:100',
            'type' => 'sometimes|nullable|numeric'
        ]);
        // Find the required model instance.
        $selected_default_email_response_text = DefaultEmailResponseText::findOrFail($id);
        // Create the new model instance.
        $selected_default_email_response_text->update([
            'text' => $request->text,
            'type' => $request->type
        ]);
        // Return a redirect to the index route.
        return redirect()
            ->route('default-email-response-text.index')
            ->with('success', 'You have successfully created a new default email response text.');
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
        $selected_default_email_response_text = DefaultEmailResponseText::findOrFail($id);
        // Delete the selected model instance.
        $selected_default_email_response_text->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('default-email-response-text.index')
            ->with('success', 'You have successfully deleted the selected default email response text.');
    }
}
