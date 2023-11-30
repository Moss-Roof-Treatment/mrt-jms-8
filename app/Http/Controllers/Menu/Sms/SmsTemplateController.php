<?php

namespace App\Http\Controllers\Menu\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsTemplate;
use App\Models\System;

class SmsTemplateController extends Controller
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
        $templates = SmsTemplate::orderBy('title', 'asc')
            ->get();
        // Return the index view.
        return view('menu.sms.templates.index')
            ->with('templates', $templates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view.
        return view('menu.sms.templates.create');
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
            'title' => 'required|string|min:3|max:255',
            'text' => 'required|string|min:15|max:1500',
        ]);
        // Create a new model instance.
        $new_template = SmsTemplate::create([
            'title' => ucwords($request->title),
            'text' => ucfirst($request->text),
            'is_delible' => 1
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('sms-templates.show', $new_template->id)
            ->with('success', 'You have successfully created the new sms template.');
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
        $selected_template = SmsTemplate::findOrFail($id);
        // Set The Required Variables.
        // Find the current system.
        $selected_system = System::firstOrFail(); // Moss Roof Treatment.
        // Return the show view.
        return view('menu.sms.templates.show')
            ->with([
                'selected_system' => $selected_system,
                'selected_template' => $selected_template
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
        // Find the required model instance.
        $selected_template = SmsTemplate::findOrFail($id);
        // Return the edit view.
        return view('menu.sms.template.edit')
            ->with('selected_template', $selected_template);
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
        // Check editable status.
        $selected_template = SmsTemplate::findOrFail($id);
        // Secondary validation.
        if ($selected_template->is_editable == 0) { // Not editable.
            // Return a redirect back.
            return back()
                ->with('danger', 'This sms template is not editable.');
        }
        // Validate The Request Data.
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'text' => 'required|string|min:15|max:1500',
        ]);
        // Find and update the selected model instance.
        $selected_template->update([
            'title' => ucwords($request->title),
            'text' => ucfirst($request->text)
        ]);
        // Return a redirect to the show route.
        return redirect()
            ->route('sms-templates.show', $id)
            ->with('success', 'You have successfully updated the selected sms template.');
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
        $selected_template = SmsTemplate::findOrFail($id);
        // Validate model relationship existance.
        // Check if there are group sms with this sms template.
        if ($selected_template->group_sms()->exists()) {
            // Return a redirect back.
            return back()
                ->with('danger', 'Cannot delete the selected sms template as there are group sms that contain this sms template. Please delete the sms that contain this sms template before attempting to delete this selected sms template.');
        }
        // Delete the selected model instance.
        $selected_template->delete();
        // Return a redirect to the index route.
        return redirect()
            ->route('sms-templates.index')
            ->with('success', 'You have successfully deleted the selected sms template.');
    }
}
